<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::with('employee')->get();

        if ($positions->isEmpty()) {
            return response()->json([
                'message' => 'No Records Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['position' => ['No Records Found.']]
            ], Status::NOT_FOUND);
        }

        return response()->json(['position' => $positions], Status::SUCCESS);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'employee_id' => 'required|exists:employees,id',
    //         'job_position' => 'required|string'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message' => 'Validation failed.',
    //             'status' => Status::INVALID_REQUEST,
    //             'errors' => $validator->errors()
    //         ], Status::INVALID_REQUEST);
    //     }

    //     $position = new Position();
    //     $position->employee_id = $request->employee_id;
    //     $position->job_position = $request->job_position;
    //     $position->save();

    //     return response()->json(['message' => 'Job Position Add Successfully'], Status::SUCCESS);
    // }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'job_position' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'status' => Status::INVALID_REQUEST,
                'errors' => $validator->errors()
            ], Status::INVALID_REQUEST);
        }

        $existingPosition = Position::where('employee_id', $request->employee_id)
            ->where('job_position', $request->job_position)
            ->first();

        if ($existingPosition) {
            return response()->json([
                'message' => 'Validation failed.',
                'status' => Status::INVALID_REQUEST,
                'errors' => [
                    'job_position' => ['This position is already assigned to this employee.']
                ]
            ], Status::INVALID_REQUEST);
        }

        $position = new Position();
        $position->employee_id = $request->employee_id;
        $position->job_position = $request->job_position;
        $position->save();

        return response()->json(['message' => 'Job Position Add Successfully'], Status::SUCCESS);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $position = Position::find($id);

        if (!$position) {
            return response()->json([
                'message' => 'Job Position Not Found',
                'status' => Status::NOT_FOUND,
                'errors' => ['position' => ['Job position not found.']]
            ], Status::NOT_FOUND);
        }

        return response()->json(['position' => $position], Status::SUCCESS);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $position = Position::find($id);

    //     if (!$position) {
    //         return response()->json([
    //             'message' => 'Job Position Not Found',
    //             'status' => Status::NOT_FOUND,
    //             'errors' => ['position' => ['Job position not found.']]
    //         ], Status::NOT_FOUND);
    //     }

    //     $validator = Validator::make($request->all(), [
    //         'employee_id' => 'sometimes|exists:employees,id',
    //         'job_position' => 'sometimes|string'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message' => 'Validation failed.',
    //             'status' => Status::INVALID_REQUEST,
    //             'errors' => $validator->errors()
    //         ], Status::INVALID_REQUEST);
    //     }

    //     $position->employee_id = $request->employee_id;
    //     $position->job_position = $request->job_position;
    //     $position->save();

    //     return response()->json(['message' => 'Job Position Updated Successfully'], Status::SUCCESS);
    // }

    /**
 * Update the specified resource in storage.
 */
    public function update(Request $request, string $id)
        {
            $position = Position::find($id);

            if (!$position) {
                return response()->json([
                    'message' => 'Job Position Not Found',
                    'status' => Status::NOT_FOUND,
                    'errors' => ['position' => ['Job position not found.']]
                ], Status::NOT_FOUND);
            }

            $validator = Validator::make($request->all(), [
                'employee_id' => 'sometimes|exists:employees,id',
                'job_position' => 'sometimes|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'status' => Status::INVALID_REQUEST,
                    'errors' => $validator->errors()
                ], Status::INVALID_REQUEST);
            }

            $existingPosition = Position::where('employee_id', $request->employee_id)
                ->where('job_position', $request->job_position)
                ->where('id', '!=', $id)
                ->first();

            if ($existingPosition) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'status' => Status::INVALID_REQUEST,
                    'errors' => [
                        'job_position' => ['This position is already assigned to this employee.']
                    ]
                ], Status::INVALID_REQUEST);
            }

            $position->employee_id = $request->employee_id;
            $position->job_position = $request->job_position;
            $position->save();

            return response()->json(['message' => 'Job Position Updated Successfully'], Status::SUCCESS);
        }
        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            $position = Position::find($id);

            if (!$position) {
                return response()->json([
                    'message' => 'Job Position Not Found',
                    'status' => Status::NOT_FOUND,
                    'errors' => ['position' => ['Job position not found.']]
                ], Status::NOT_FOUND);
            }

            $position->delete();
            return response()->json(['message' => 'Job Position Delete Successfully'], Status::SUCCESS);
        }
    }
?>
