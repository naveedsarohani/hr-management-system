<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use DateTime;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendance = Attendance::with('employee')->get();
        return response()->json(['attendance', $attendance], Status::SUCCESS);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in_time' => 'required|date_format:h:i A',
            'check_out_time' => 'required|date_format:h:i A',
            'status' => 'required|in:present,absent,on leave'
        ]);

        $checkInTime = DateTime::createFromFormat('h:i A', $request->check_in_time)->format('H:i');
        $checkOutTime = DateTime::createFromFormat('h:i A', $request->check_out_time)->format('H:i');

        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'check_in_time' => $checkInTime,
            'check_out_time' => $checkOutTime,
            'status' => $request->status
        ]);
        return response()->json(['message' => 'Attendance Add Successfully', Status::SUCCESS]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attendance = Attendance::find($id);

        if(!$attendance)
        {
            return response()->json(['message' => 'Attendance Not Found'], Status::NOT_FOUND);
        }

        return response()->json(['attendance' => $attendance], Status::SUCCESS);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], Status::NOT_FOUND);
        }

        $request->validate([
            'date' => 'date',
            'check_in_time' => 'date_format:h:i A',
            'check_out_time' => 'date_format:h:i A',
            'status' => 'in:present,absent,on leave'
        ]);

        $checkInTime = DateTime::createFromFormat('h:i A', $request->check_in_time)->format('H:i');
        $checkOutTime = DateTime::createFromFormat('h:i A', $request->check_out_time)->format('H:i');

        $attendance->update([
            'date' => $request->date,
            'check_in_time' => $checkInTime,
            'check_out_time' => $checkOutTime,
            'status' => $request->status
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
            return response()->json(['message' => 'Attendance Not Found'], Status::NOT_FOUND);
        }

        $attendance->delete();
        return response()->json(['message' => 'Attendance Delete Successfully'], Status::SUCCESS);
    }
}
