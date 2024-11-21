<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($q = $request->get('q')) {
                $applications = Application::with('job')->where('status', 'like', "%{$q}%")->orWhere('candidate_name', 'like', "%{$q}%")->get();
            } else $applications = Application::with('job')->get();

            return $this->successResponse(Status::SUCCESS, 'all appplications with job data', compact('applications'));
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'job_id' => 'required',
            'candidate_name' => [
                'required',
                'min:4',
                'max:255',
                'regex:/^[a-zA-Z]+[a-zA-Z\s]*$/'
            ],
            'email' => 'required|email:rfc,dns|unique:applications,email',
            'contact_number' => [
                'required',
                'regex:/^\+?[0-9]{10,12}$/'
            ],
            'cover_letter' => 'required|min:10',
            'portfolio_link' => 'sometimes|nullable',
            'expected_salary' => 'required|max:10',
            'notice_period' => [
                'required',
                'regex:/^(1 week|15 days|1 month)$/'
            ],
            'status' => 'required|in:pending,interview,hired,rejected',
            'resume' => 'required|mimes:pdf|max:3072',
        ]);

        if ($validation->fails()) {
            return $this->errorResponse(Status::INVALID_REQUEST, 'there wass validation failure', $validation->errors()->toArray());
        }

        try {
            if (!$job = Job::find($request->job_id)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid job ID');
            }

            $resume = $request->file('resume');
            if (!$resume_path = $resume->move(public_path('uploads'), $resume->hashName())) {
                throw new Exception('failed to upload resume');
            };

            $data = $request->except('job_id');
            $data['resume'] = 'uploads/' . basename($resume_path);

            if (!$job->application()->create($data)) {
                throw new Exception('failed to create a new job application');
            }

            return $this->successResponse(Status::SUCCESS, 'a new job application was created');
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function show(string $applicationId)
    {
        try {
            if (!$application = Application::with('job')->find($applicationId)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid job application ID');
            };

            return $this->successResponse(Status::SUCCESS, 'requested job application', compact('application'));
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(Request $request, string $applicationId)
    {
        $validation = Validator::make($request->all(), [
            'candidate_name' => [
                'sometimes',
                'required',
                'min:4',
                'max:255',
                'regex:/^[a-zA-Z]+[a-zA-Z\s]*$/'
            ],
            'email' => 'sometimes|required|email:rfc,dns|unique:applications,email,' . $applicationId . ',id',
            'contact_number' => [
                'sometimes',
                'required',
                'regex:/^\+?[0-9]{10,12}$/'
            ],
            'cover_letter' => 'sometimes|required|min:10',
            'portfolio_link' => 'sometimes|nullable',
            'expected_salary' => 'sometimes|required|max:10',
            'notice_period' => [
                'sometimes',
                'required',
                'regex:/^(1 week|15 days|1 month)$/'
            ],
            'status' => 'sometimes|required|in:pending,interview,hired,rejected',
            'resume' => 'sometimes|required|mimes:pdf|max:3072',
        ]);

        if ($validation->fails()) {
            return $this->errorResponse(Status::INVALID_REQUEST, 'there was validation failure', $validation->errors()->toArray());
        }

        try {
            if (!$application = Application::find($applicationId)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid job application ID');
            };

            $data = $request->except('resume');
            if ($resume = $request->file('resume')) {
                if (File::exists($resume_path = public_path($application->resume))) File::delete($resume_path);

                $resume_path = $resume->move(public_path('uploads'), $resume->hashName());
                $data['resume'] = 'uploads/' . basename($resume_path);
            }

            if (!$application->update($data)) {
                throw new Exception('failed to update job application details');
            }

            return $this->successResponse(Status::SUCCESS, 'the job application details was updated');
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function destroy(string $applicationId)
    {
        try {
            if (!$application = application::find($applicationId)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid job application ID');
            };

            if (!$application->delete()) {
                throw new Exception('failed to delete job application');
            }

            return $this->successResponse(Status::SUCCESS, 'the job application was deleted');
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
