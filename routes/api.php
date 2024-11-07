<?php

use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::controller(AuthController::class)->group(function(){
        Route::post('/login', 'login');
        Route::post('/hr-register', 'hrSelfRegister');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/logout', 'logout');

            Route::middleware('is_admin_or_hr')->group(function () {
                Route::post('/register', 'register');
                Route::post('/approve-user/{id}', 'approveUser');
            });
        });
    });
});

// employee routes maintained by naveed
Route::apiResource('employees', EmployeeController::class)->middleware('auth:sanctum');
