<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Job;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($q = $request->get('q')) {
                $jobs = Job::where('title', 'like', "%{$q}%")->orWhere('description', 'like', "%{$q}%")->orWhere('status', 'like', "%{$q}%")->get();
            } else {
                $jobs = Job::all();
            }

            return $this->successResponse(Status::SUCCESS, 'all job records', compact('jobs'));
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($data = $request->all(), [
            'title' => 'required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/|min:10|max:255',
            'description' => 'required|min:10',
            'experience' => 'required|min:10|max:255',
            'employment_type' => 'required|in:full-time,part-time,contract,internship',
            'job_location' => 'required|min:10|max:255',
            'salary_range' => 'required|regex:/^[50-70]+k$/',
            'qualifications' => 'required|min:10|max:255',
            'benefits' => 'required|nullable',
            'skills_required' => 'required|nullable',
            'status' => 'required|in:open,closed',
        ]);

        if ($validation->fails()) {
            return $this->errorResponse(Status::INVALID_REQUEST, 'there was validation failure', $validation->errors()->toArray());
        }

        try {
            if (!Job::create($data)) {
                throw new Exception('failed to create new job advertisement');
            }

            return $this->successResponse(Status::SUCCESS, 'a new job advertisement was was published');
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function show(string $jobId)
    {
        try {
            if (!$job = Job::find($jobId)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid job advertisement ID');
            };

            return $this->successResponse(Status::SUCCESS, 'requested job advertisement', compact('job'));
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(Request $request, string $jobId)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'sometimes|required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/|min:10|max:255',
            'description' => 'sometimes|required|min:10',
            'experience' => 'sometimes|required|min:10|max:255',
            'employment_type' => 'sometimes|required|in:full-time,part-time,contract,internship',
            'job_location' => 'sometimes|required|min:10|max:255',
            'salary_range' => 'sometimes|required|regex:/^[50-70]+k$/',
            'qualifications' => 'sometimes|required|min:10|max:255',
            'benefits' => 'sometimes|required|nullable',
            'status' => 'sometimes|required|in:open,closed',
        ]);

        if ($validation->fails()) {
            return $this->errorResponse(Status::INVALID_REQUEST, 'there was validation failure', $validation->errors()->toArray());
        }

        try {
            if (!$job = Job::find($jobId)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid job advertisement ID');
            };

            if (!$job->update($request->except('_method'))) {
                throw new Exception('failed to update job advertisement');
            }

            return $this->successResponse(Status::SUCCESS, 'the job advertisement was updated');
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function destroy(string $jobId)
    {
        try {
            if (!$job = Job::find($jobId)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid job advertisement ID');
            };

            if (!$job->delete()) {
                throw new Exception('failed to delete job advertisement');
            }

            return $this->successResponse(Status::SUCCESS, 'the job advertisement was deleted');
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
