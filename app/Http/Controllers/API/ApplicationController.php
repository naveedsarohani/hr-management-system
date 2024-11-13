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
    public function index()
    {
        try {
            $applications = Application::with('job')->get();
            return $this->successResponse(Status::SUCCESS, 'all appplications with job data', compact('applications'));
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'job_id' => 'required',
            'candidate_name' => 'required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/|min:4|max:255',
            'email' => 'required|email:rfc,dns|unique:applications,email',
            'status' => 'required|in:pending,interview,hired,rejected',
            'resume' => 'required|mimes:pdf',
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

    public function search(Request $request)
    {
        if (!$q = $request->get('q')) {
            return $this->errorResponse(Status::INVALID_REQUEST, 'the query parameter must be set');
        }

        try {
            $filterredApplications = Application::with('job')->where('status', 'like', "%{$q}%")->orWhere('candidate_name', 'like', "%{$q}%")->get();

            return $this->successResponse(Status::SUCCESS, 'matched job advertisements against query', compact('filterredApplications'));
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(Request $request, string $applicationId)
    {
        $validation = Validator::make($request->all(), [
            'candiate_name' => 'sometimes|required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/|min:4|max:100',
            'email' => 'sometimes|required|email:rfc,dns|unique:applications,email',
            'resume' => 'sometimes|required|mimes:pdf',
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
