<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\TaskController;
use App\Http\Controllers\Project\RemarkController;
use App\Http\Controllers\Project\ReportController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user_details']);
});

Route::middleware('auth:api')->prefix('projects')->group(function () {
    Route::get('/create', [ProjectController::class, 'index']);
    Route::post('/create', [ProjectController::class, 'store']);
    Route::put('/{project}/update', [ProjectController::class, 'update']);
    Route::delete('/{project}/delete', [ProjectController::class, 'destroy']);
});


Route::middleware('auth:api')->group(function () {
    
    Route::post('/projects/{project}/tasks/create', [TaskController::class, 'store']);
    Route::put('/tasks/{task}/status', [TaskController::class, 'update_status']);

    Route::post('/tasks/{task}/remarks', [RemarkController::class, 'store']);
});


Route::middleware('auth:api')->group(function () {
    Route::post('/report/task', [ReportController::class, 'task_details']);
    Route::post('/report/status_history', [ReportController::class, 'status_history']);
    Route::post('/report/remark', [ReportController::class, 'remark_details']);
});
