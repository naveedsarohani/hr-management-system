<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Constants\Status;
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
        ]);

        $compensation = new Compensation();
        $compensation->employee_id = $request->employee_id;
        $compensation->base_salary = $request->base_salary;
        $compensation->bonus = $request->bonus;
        $compensation->total_compensation = $request->base_salary + $request->bonus;
        $compensation->save();

        return response()->json(['message', 'Compensation Add Successfully', Status::SUCCESS]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $compensation = Compensation::find($id);

        if(!$compensation)
        {
            return response()->json(['message' => 'Compensation Not Found'], Status::NOT_FOUND);
        }

        return response()->json(['compensation' => $compensation], Status::SUCCESS);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}