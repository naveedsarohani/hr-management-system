<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\CompanyLocation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $today = date('Y-m-d', strtotime('now'));

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date|after_or_equal:' . $yesterday,
            'time_in' => [
                Rule::requiredIf(!isset($request->time_out)),
                'regex:/^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM|am|pm)$/',
            ],
            'time_out' => [
                'nullable',
                'regex:/^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM|am|pm)$/',
            ],
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Format the time_in and time_out
        if ($request->time_in) {
            $timeIn = DateTime::createFromFormat('h:i A', $request->time_in);
            if (!$timeIn) {
                return response()->json([
                    'message' => 'Invalid time_in format.',
                    'status' => Status::INVALID_REQUEST,
                    'errors' => ['time_in' => ['Invalid time_in format.']],
                ], Status::INVALID_REQUEST);
            }
            $timeIn = $timeIn->format('h:i A');
        } else {
            $timeIn = null;
        }

        if ($request->time_out) {
            $timeOut = DateTime::createFromFormat('h:i A', $request->time_out);
            if (!$timeOut) {
                return response()->json([
                    'message' => 'Invalid time_out format.',
                    'status' => Status::INVALID_REQUEST,
                    'errors' => ['time_out' => ['Invalid time_out format.']],
                ], Status::INVALID_REQUEST);
            }
            $timeOut = $timeOut->format('h:i A');
        } else {
            $timeOut = null;
        }

        $request->merge([
            'time_in' => $timeIn,
            'time_out' => $timeOut,
        ]);

        // Check if company location exists
        $companyLocation = CompanyLocation::where('location', $request->location)
            ->where('latitude', $request->latitude)
            ->where('longitude', $request->longitude)
            ->first();

        if (!$companyLocation) {
            return response()->json([
                'message' => 'Company location not found.',
                'status' => Status::INVALID_REQUEST,
                'errors' => ['location' => ['Company location not found.']],
            ], Status::INVALID_REQUEST);
        }

        // Check for existing attendance record
        if (!$request->time_out) {
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
        }

        // Update attendance record if time_out is provided
        if ($request->time_out) {
            $attendance = Attendance::where('employee_id', $request->employee_id)
                ->where('date', $request->date)
                ->first();

            if ($attendance) {
                $attendance->update([
                    'time_out' => $timeOut,
                ]);

                return response()->json(['message' => 'Attendance updated successfully'], Status::SUCCESS);
            } else {
                return response()->json([
                    'message' => 'Attendance not found for this date.',
                    'status' => Status::INVALID_REQUEST,
                    'errors' => ['attendance' => ['Attendance not found for this date.']],
                ], Status::INVALID_REQUEST);
            }
        }

        // Create a new attendance record
        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'time_in' => $timeIn,
            'time_out' => $timeOut,
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
