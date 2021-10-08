<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentModuleController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModuleMarksController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentMarksController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherModuleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Auth routes
Route::middleware('auth:sanctum')->get('/auth/user', [AuthController::class, 'user']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);

// Student routes
Route::apiResource('students', StudentController::class);

// Teacher routes
Route::get('/teachers/{teacher}/modules', [TeacherModuleController::class, 'index']);
Route::apiResource('teachers', TeacherController::class);

// Departments
Route::apiResource('departments', DepartmentController::class);

// Modules
Route::get('/modules', [ModuleController::class, 'index']);
Route::post('/modules', [ModuleController::class, 'store']);
Route::apiResource('departments.modules', DepartmentModuleController::class)->shallow();

// Marks - (Module)
Route::get('/marks', [MarkController::class, 'index']);
Route::post('/marks', [MarkController::class, 'store']);
Route::apiResource('modules.marks', ModuleMarksController::class)->shallow();

// Marks - (Student)
Route::apiResource('students.marks', StudentMarksController::class)->only(['index', 'store']);
