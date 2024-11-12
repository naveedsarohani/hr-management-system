<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $employees = Employee::all();
            return $this->successResponse(Status::SUCCESS, 'all employees records', compact('employees'));
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/|min:4|max:100',
            'last_name' => 'required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/|min:4|max:100',
            'email' => 'required|email:rfc,dns|unique:employees,email',
            'phone' => 'sometimes|required|numeric|regex:/\+?[0-9]{10,11}$/',
            'address' => 'required|min:10|max:255',
            'department' => 'required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/',
            'position' => 'required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/',
            'date_of_joining' => 'required|date',
        ]);

        if ($validation->fails()) {
            return $this->errorResponse(Status::INVALID_REQUEST, 'there was validation failure', $validation->errors()->toArray());
        }

        try {
            if (!$user = User::find(auth()->id())) {
                throw new Exception('there is an internal error');
            }

            if (!$user->employee()->create($request->all())) {
                throw new Exception('failed to create new employee resource');
            }

            return $this->successResponse(Status::SUCCESS, 'a new employe resource was created');
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function show(string $employeeId)
    {
        try {
            $employee = Employee::find($employeeId);
            if (!$employee) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid employee ID');
            };

            return $this->successResponse(Status::SUCCESS, 'requested employee data', compact('employee'));
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(Request $request, string $employeeId)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/|min:4|max:100',
            'last_name' => 'sometimes|required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/|min:4|max:100',
            'email' => 'sometimes|required|email:rfc,dns|unique:employees,email,' . $employeeId . ',id',
            'phone' => 'sometimes|required|numeric|regex:/\+?[0-9]{10,11}$/',
            'address' => 'sometimes|required|min:10|max:255',
            'department' => 'sometimes|required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/',
            'position' => 'sometimes|required|regex:/^[a-zA-Z]+[a-zA-Z\s]*/',
            'date_of_joining' => 'sometimes|required|date',
        ]);

        if ($validation->fails()) {
            return $this->errorResponse(Status::INVALID_REQUEST, 'there was validation failure', $validation->errors()->toArray());
        }

        try {
            if (!$employee = Employee::find($employeeId)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid employee ID');
            };

            if (!$employee->update($request->except('_method'))) {
                throw new Exception('failed to update employee resource');
            }

            return $this->successResponse(Status::SUCCESS, 'the employee data was updated');
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function destroy(string $employeeId)
    {
        try {
            if (!$employee = Employee::find($employeeId)) {
                return $this->errorResponse(Status::NOT_FOUND, 'invalid employee ID');
            };

            if (!$employee->delete()) {
                throw new Exception('failed to delete employee');
            }

            return $this->successResponse(Status::SUCCESS, 'the employee record was deleted');
        } catch (Exception $e) {
            return $this->errorResponse(Status::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
