<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaints = Complaint::with(['employee', 'hr'])->get();

        if ($complaints->isEmpty()) {
            return response()->json([
                'message' => 'No Records Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['department' => ['No records found.']]
            ], Status::NOT_FOUND);
        }

        return response()->json(['complaints' => $complaints], Status::SUCCESS);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(),[
            'employee_id' => 'required|exists:employees,id',
            'complaint_date' => 'required|date',
            'complaint_text' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'status' => Status::INVALID_REQUEST,
                'errors' => $validator->errors()
            ], Status::INVALID_REQUEST);
        }

        $complaint = new Complaint();
        $complaint->employee_id = $request->employee_id;
        $complaint->complaint_date = $request->complaint_date;
        $complaint->complaint_text = $request->complaint_text;
        $complaint->save();

        return response()->json(['message' => 'Complaint Add Successfully'], Status::SUCCESS);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response()->json([
                'message' => 'Complaint Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['complaint' => ['Complaint not found.']]
            ], Status::NOT_FOUND);
        }

        return response()->json(['complaint' => $complaint], Status::SUCCESS);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response()->json([
                'message' => 'Complaint Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['department' => ['Complaint not found.']]
            ], Status::NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'in:pending,resolved,closed',
            'hr_response' => 'nullable|string',
            'hr_resolved_by' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'status' => Status::INVALID_REQUEST,
                'errors' => $validator->errors()
            ], Status::INVALID_REQUEST);
        }

        $complaint->status = $request->status;
        $complaint->hr_response = $request->hr_response;
        $complaint->hr_resolved_by = $request->hr_resolved_by;
        $complaint->save();

        return response()->json(['message' => 'Complaint Updated Successfully'], Status::SUCCESS);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response()->json([
                'message' => 'Complaint Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['department' => ['Complaint not found.']]
            ], Status::NOT_FOUND);
        }

        $complaint->delete();
        return response()->json(['message' => 'Complaint Delete Successfully'], Status::SUCCESS);
    }
}
