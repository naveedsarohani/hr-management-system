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
    public function index()
    {
        try {
            $jobs = Job::all();
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

    public function search(Request $request)
    {
        if (!$q = $request->get('q')) {
            return $this->errorResponse(Status::INVALID_REQUEST, 'the query parameter must be set');
        }

        try {
            $filterredJobs = Job::where('title', 'like', "%{$q}%")->orWhere('description', 'like', "%{$q}%")->orWhere('status', 'like', "%{$q}%")->get();

            return $this->successResponse(Status::SUCCESS, 'matched job advertisements against query', compact('filterredJobs'));
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(Request $request, string $jobId)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'sometimes|required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/|min:10|max:255',
            'description' => 'sometimes|required|min:10',
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
