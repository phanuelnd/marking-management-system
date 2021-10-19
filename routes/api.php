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
use App\Http\Controllers\UserUpdateController;
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

// Route::group(function () {
// User Update routes
Route::middleware(['auth:sanctum', 'user_type'])->post('/auth/user/change-info', [UserUpdateController::class, 'changeInfo']);
Route::middleware(['auth:sanctum', 'user_type'])->post('/auth/user/change-password', [UserUpdateController::class, 'changePassword']);

// Auth routes
Route::middleware('auth:sanctum')->get('/auth/user', [AuthController::class, 'user']);
Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);

// Student routes
Route::middleware('auth:sanctum')->apiResource('students', StudentController::class);

// Teacher routes
Route::middleware('auth:sanctum')->get('/teachers/{teacher}/modules', [TeacherModuleController::class, 'index']);
Route::middleware('auth:sanctum')->apiResource('teachers', TeacherController::class);

// Departments
Route::middleware('auth:sanctum')->apiResource('departments', DepartmentController::class);

// Modules
Route::middleware('auth:sanctum')->get('/modules', [ModuleController::class, 'index']);
Route::middleware('auth:sanctum')->get('/modules/{module}/students', [ModuleController::class, 'students']);
Route::middleware('auth:sanctum')->post('/modules', [ModuleController::class, 'store']);
Route::middleware('auth:sanctum')->apiResource('departments.modules', DepartmentModuleController::class)->shallow();

// Marks - (Module)
Route::middleware('auth:sanctum')->get('/marks', [MarkController::class, 'index']);
Route::middleware('auth:sanctum')->post('/marks', [MarkController::class, 'store']);
Route::middleware('auth:sanctum')->apiResource('modules.marks', ModuleMarksController::class)->shallow();

// Marks - (Student)
Route::middleware('auth:sanctum')->apiResource('students.marks', StudentMarksController::class)->only(['index', 'store']);

// Login route
Route::post('/auth/login', [AuthController::class, 'login']);
