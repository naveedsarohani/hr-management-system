<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compensation;

class CompensationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compensations = Compensation::with('employee')->get();

        if ($compensations->isEmpty()) {
            return response()->json(['message' => 'No Records Found'], Status::NOT_FOUND);
        }

        return response()->json(['compensation', $compensations], Status::SUCCESS);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'base_salary' => 'required|numeric',
            'bonus' => 'required|numeric',
            'payment_date' => 'date',
            'payment_month' => ['required', 'regex:/20[0-9]{2}-(0[1-9]|1[0-2])/']
        ]);

        $compensation = new Compensation();
        $compensation->employee_id = $request->employee_id;
        $compensation->base_salary = $request->base_salary;
        $compensation->bonus = $request->bonus;
        $compensation->total_compensation = $request->base_salary + $request->bonus;
        $compensation->payment_date = $request->payment_date;
        $compensation->payment_month = $request->payment_month;

        $compensation->save();

        return response()->json(['message' => 'Compensation Add Successfully', Status::SUCCESS]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $compensation = Compensation::find($id);

        if (!$compensation) {
            return response()->json(['message' => 'Compensation Not Found'], Status::NOT_FOUND);
        }

        return response()->json(['compensation' => $compensation], Status::SUCCESS);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $compensation = Compensation::find($id);

        if (!$compensation) {
            return response()->json(['message' => 'Compensation not found'], Status::NOT_FOUND);
        }

        $request->validate([
            'base_salary' => 'numeric',
            'bonus' => 'numeric',
            'payment_date' => 'date',
            'payment_month' => ['required', 'regex:/20[0-9]{2}-(0[1-9]|1[0-2])/']
        ]);

        $compensation->base_salary = $request->base_salary;
        $compensation->bonus = $request->bonus;
        $compensation->total_compensation = $request->base_salary + $request->bonus;
        $compensation->payment_date = $request->payment_date;
        $compensation->payment_month = $request->payment_month;

        $compensation->save();

        return response()->json(['message' => 'Compensation Update Successfully'], Status::SUCCESS);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $compensation = Compensation::find($id);

        if (!$compensation) {
            return response()->json(['message' => 'Compensation not found'], Status::NOT_FOUND);
        }

        $compensation->delete();
        return response()->json(['message' => 'Compensation Delete Successfully'], Status::SUCCESS);
    }
}
