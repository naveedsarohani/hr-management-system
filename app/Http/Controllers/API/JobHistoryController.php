<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\JobHistory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class JobHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobHistory = JobHistory::with('employee', 'position', 'department')->get();

        if($jobHistory->isEmpty())
        {
            return response()->json([
                'message' => 'No Record Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['job_history' => ['No Record Found']]
            ], Status::NOT_FOUND);
        }

        return response()->json(['job_history' => $jobHistory], Status::SUCCESS);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(),[
            'employee_id' => 'required|exists:employees,id',
            'position_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
            'employment_from' => 'required|date',
            'status' => 'required|in:previous,latest'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'message' => 'Validation failed.',
                'status' => Status::INVALID_REQUEST,
                'error' => $validator->errors()
            ],Status::INVALID_REQUEST);
        }

        $job_history = new JobHistory();
        $job_history->employee_id = $request->employee_id;
        $job_history->position_id = $request->position_id;
        $job_history->department_id = $request->department_id;
        $job_history->employment_from = $request->employment_from;
        $job_history->employment_to = $request->employment_to;
        $job_history->save();

        return response()->json(['message' => 'Job History Add Successfully'], Status::SUCCESS);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job_history = JobHistory::find($id);

        if (!$job_history) {
            return response()->json([
                'message' => 'Job History Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['job_history' => ['Job History not found.']]
            ], Status::NOT_FOUND);
        }

        return response()->json(['job_history' => $job_history], Status::SUCCESS);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $job_history = JobHistory::find($id);

        if (!$job_history) {
            return response()->json([
                'message' => 'Job History Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['job_history ' => ['Job History not found.']]
            ], Status::NOT_FOUND);
        }

        $validator = validator::make($request->all(),[
            'employee_id' => 'sometimes|required|exists:employees,id',
            'position_id' => 'sometimes|required|exists:positions,id',
            'department_id' => 'sometimes|required|exists:departments,id',
            'employment_from' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:previous,latest'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'message' => 'Validation failed.',
                'status' => Status::INVALID_REQUEST,
                'error' => $validator->errors()
            ],Status::INVALID_REQUEST);
        }

        $job_history->employee_id = $request->employee_id;
        $job_history->position_id = $request->position_id;
        $job_history->department_id = $request->department_id;
        $job_history->employment_from = $request->employment_from;
        $job_history->employment_to = $request->employment_to;
        $job_history->status = $request->status;
        $job_history->save();

        return response()->json(['message' => 'Job History Details Update Successfully'], Status::SUCCESS);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job_history = JobHistory::find($id);

        if (!$job_history) {
            return response()->json([
                'message' => 'Job History Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['job_history' => ['Job History not found.']]
            ], Status::NOT_FOUND);
        }

        $job_history->delete();
        return response()->json(['message' => 'Job History Delete Successfully'], Status::SUCCESS);
    }
}
