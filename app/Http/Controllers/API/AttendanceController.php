<?php

namespace App\Http\Controllers\API;

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

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date|after_or_equal:' . $yesterday . '|before_or_equal:' . $today,
            'time_in' => [
                'required',
                'regex:/^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM|am|pm)$/',
            ],
            'time_out' => [
                'nullable',
                'regex:/^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM|am|pm)$/',
            ],
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Format the time_in and time_out
        $timeIn = DateTime::createFromFormat('h:i A', $request->time_in)->format('h:i A');
        $timeOut = $request->time_out
            ? DateTime::createFromFormat('h:i A', $request->time_out)->format('h:i A')
            : null;

        $request->merge([
            'time_in' => $timeIn,
            'time_out' => $timeOut,
        ]);

        // Check for existing attendance record
        $existingAttendance = Attendance::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->exists();

        if ($existingAttendance) {
            return response()->json([
                'message' => 'Attendance already exists for this date.',
                'status' => Status::INVALID_REQUEST,
                'errors' => ['attendance' => ['Attendance already exists for this date.']],
            ], Status::INVALID_REQUEST);
        }

        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
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

}
