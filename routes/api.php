<?php

use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\ApI\AuthController;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\ApI\PerformanceReviewController;
use App\Http\Controllers\API\CompensationController;
use Illuminate\Support\Facades\Route;

/*Routes Maintained BY Wajid Laghari*/

#Authentication
Route::group(['prefix' => 'auth'], function () {
    Route::controller(AuthController::class)->group(function(){
        Route::post('/login', 'login');
        Route::post('/hr-self-register', 'register');
        Route::get('/logout', 'logout')->middleware('auth:sanctum');;
    });
});

#Admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'is_admin']], function () {
    Route::controller(AuthController::class)->group(function(){
        Route::post('/admin-hr-register', 'register');
        Route::get('/hrs', 'showAllHRS');
        Route::delete('/delete-hr/{id}', 'deleteHR');
        Route::put('/update-hr/{id}', 'updateHR');
        Route::get('/show-hr/{id}', 'showHR');
        Route::post('/update-status-hr/{id}', 'updateUserStatus');
    });
});

#PerformanceReviews
Route::apiResource('performance-reviews', PerformanceReviewController::class)->middleware(['auth:sanctum', 'is_admin_or_hr']);

#Compensations
Route::apiResource('compensations', CompensationController::class)->middleware(['auth:sanctum', 'is_admin_or_hr']);


// ROUTES MAINTAINED BY NAVEED

# employees
Route::apiResource('employees', EmployeeController::class)->middleware('auth:sanctum');

# jobs
Route::controller(JobController::class)->prefix('jobs')->group(function () {
    Route::get('/', 'index');
    Route::get('/get/{id}', 'show');
    Route::get('/search', 'search');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});
