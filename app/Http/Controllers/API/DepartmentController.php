<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();

        if ($departments->isEmpty()) {
            return response()->json([
                'message' => 'No Records Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['department' => ['No records found.']]
            ], Status::NOT_FOUND);
        }

        return response()->json(['department' => $departments], Status::SUCCESS);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:departments,title',
        ], [
            'title.unique' => 'Department already exists',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'status' => Status::INVALID_REQUEST,
                'errors' => $validator->errors()
            ], Status::INVALID_REQUEST);
        }

        $department = new Department();
        $department->title = $request->title;
        $department->save();

        return response()->json(['message' => 'Department Add Successfully'], Status::SUCCESS);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['department' => ['Department not found.']]
            ], Status::NOT_FOUND);
        }

        return response()->json(['department' => $department], Status::SUCCESS);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['department' => ['Department not found.']]
            ], Status::NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|unique:departments,title,'.$id,
        ], [
            'title.unique' => 'Department already exists',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'status' => Status::INVALID_REQUEST,
                'errors' => $validator->errors()
            ], Status::INVALID_REQUEST);
        }

        $department->title = $request->title;
        $department->save();

        return response()->json(['message' => 'Department Updated Successfully'], Status::SUCCESS);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['department' => ['Department not found.']]
            ], Status::NOT_FOUND);
        }

        $department->delete();
        return response()->json(['message' => 'Department Delete Successfully'], Status::SUCCESS);
    }
}
?>
