<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Leave;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        try {
            $leaves = Leave::with('employee')->get();
            return $this->successResponse(Status::SUCCESS, 'all office leave requests', compact('leaves'));
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'employee_id' => 'required',
            'leave_date' => 'required|date',
            'leave_reason' => ['required', 'regex:/^[a-zA-z][a-zA-Z0-9_@%!()\s\.\\-]{5,}/'],
        ]);

        if ($validation->fails()) {
            return $this->errorResponse(Status::INVALID_REQUEST, 'there was validation failure', $validation->errors()->toArray());
        }

        try {
            if (!$employee = Employee::find($request->employee_id)) {
                return $this->errorResponse(Status::NOT_FOUND, 'the provided employee ID was invalid');
            }
            if (!$employee->leave()->create($request->except('employee_id'))) {
                throw new Exception("failed to request office leave for {$employee->first_name} {$employee->last_name}");
            }

            return $this->successResponse(Status::SUCCESS, "a new office leave request for {$employee->first_name} {$employee->last_name} was sent");
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function show(string $leaveId)
    {
        try {
            if (!$leave = Leave::with('employee')->find($leaveId)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid office leave request ID');
            };

            return $this->successResponse(Status::SUCCESS, 'requested office leave request details', compact('leave'));
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(Request $request, string $leaveId)
    {
        $validation = Validator::make($request->all(), [
            'leave_date' => 'sometimes|required|date',
            'leave_reason' => ['sometimes', 'required', 'regex:/^[a-zA-z][a-zA-Z0-9_@%!()\s\.\\-]{5,}/'],
            'leave_status' => 'sometimes|nullable|in:pending,accepted,rejected',
        ]);

        if ($validation->fails()) {
            return $this->errorResponse(Status::INVALID_REQUEST, 'there was validation failure', $validation->errors()->toArray());
        }

        try {
            if (!$leave = Leave::find($leaveId)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid office leave request ID');
            };

            if (!$leave->update($request->except('_method'))) {
                throw new Exception('failed to update office leave request details');
            }

            return $this->successResponse(Status::SUCCESS, 'the office leave request details was updated');
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage(), $e->getLine());
        }
    }

    public function destroy(string $leaveId)
    {
        try {
            if (!$leave = Leave::find($leaveId)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid office leave request ID');
            };

            if (!$leave->delete()) {
                throw new Exception('failed to delete office leave request');
            }

            return $this->successResponse(Status::SUCCESS, 'the office leave request was deleted');
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
