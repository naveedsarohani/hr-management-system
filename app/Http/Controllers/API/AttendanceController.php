<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use DateTime;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendance = Attendance::with('employee')->get();

        if ($attendance->isEmpty()) {
            return response()->json([
                'message' => 'No Records Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['attendance' => ['No records found.']]
            ], Status::NOT_FOUND);
        }

        return response()->json(['attendance' => $attendance], Status::SUCCESS);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date|after_or_equal:'.$yesterday.'|before_or_equal:'.$today,
            'status' => [
                'required',
                'regex:/^(present|absent|on leave)$/i'
            ],
            'time' => [
                'required_if:status,present',
                'regex:/^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM|am|pm)$/'
            ]
        ]);
        $employee = Employee::find($request->employee_id);

        if ($request->status != 'absent' && $request->status != 'on leave') {
            $formattedTime = DateTime::createFromFormat('h:i A', $request->time)->format('H:i');
            $request->merge(['time' => $formattedTime]);
        } else {
            $request->merge(['time' => null]);
        }

        $existingAttendance = Attendance::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->exists();

        if ($existingAttendance) {
            return response()->json(['message' => 'Attendance already exists for today.'], Status::INVALID_REQUEST);
        }

        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'time' => $request->time,
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Attendance added successfully'], Status::SUCCESS);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attendance = Attendance::find($id);


        if (!$attendance) {
            return response()->json([
                'message' => 'Attendance Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['attendance' => ['Attendance not found.']]
            ], Status::NOT_FOUND);
        }

        return response()->json(['attendance' => $attendance], Status::SUCCESS);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json([
                'message' => 'Attendance Not Found.',
                'status' => Status::NOT_FOUND,
                'errors' => ['attendance' => ['Attendance not found.']]
            ], Status::NOT_FOUND);
        }

        $today = date('Y-m-d');

        $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'date' => 'nullable|date|before_or_equal:'.$today,
            'status' => [
                'nullable',
                'regex:/^(present|absent|on leave)$/i'
            ],
            'time' => [
                'nullable',
                'regex:/^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM|am|pm)$/',
                'required_if:status,present',
            ],
        ]);

        if ($request->has('status') && $request->status != 'absent' && $request->status != 'on leave') {
            $formattedTime = DateTime::createFromFormat('h:i A', $request->time)->format('H:i');
            $request->merge(['time' => $formattedTime]);
        } elseif ($request->has('status') && in_array($request->status, ['absent', 'on leave'])) {
            $request->merge(['time' => null]);
        }

        if ($request->date > $today && $attendance->date != $request->date) {
            return response()->json(['message' => 'Cannot update attendance for future dates.'], Status::INVALID_REQUEST);
        }

        $existingAttendance = Attendance::where('employee_id', $request->employee_id)
                                    ->where('date', $request->date)
                                    ->where('id', '!=', $id)
                                    ->exists();

      if ($existingAttendance) {
            return response()->json([
                'message' => 'Attendance already exists for today.',
                'status' => Status::INVALID_REQUEST,
                'errors' => [
                    'attendance' => ['Attendance already exists for today.']
                ]
            ], Status::INVALID_REQUEST);
        }

        $attendance->update([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'time' => $request->time,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Attendance updated successfully'], Status::SUCCESS);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json([
                'message' => 'Attendance Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['attendance' => ['Attendance not found.']]
            ], Status::NOT_FOUND);
        }

        $attendance->delete();
        return response()->json(['message' => 'Attendance Delete Successfully'], Status::SUCCESS);
    }
}
