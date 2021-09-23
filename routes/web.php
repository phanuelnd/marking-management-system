<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FocultyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Models\Mark;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware(['guest', 'guest:teacher', 'guest:student']);

/**
 * --------------------------------------------------------------------------
 * AUTH ROUTES
 * --------------------------------------------------------------------------
 */

/**
 * --------------------------------------------------------------------------
 * LOGIN ROUTES
 * --------------------------------------------------------------------------
 */

//  Student
Route::name('auth.student.')->prefix('student')->group(function () {
    Route::get('/login', [LoginController::class, 'studentLoginView'])->name('login');
    Route::post('/login', [LoginController::class, 'studentLogin']);
});

//  Teacher
Route::name('auth.teacher.')->prefix('teacher')->group(function () {
    Route::get('/login', [LoginController::class, 'teacherLoginView'])->name('login');
    Route::post('/login', [LoginController::class, 'teacherLogin']);
});

//  Admin
Route::name('auth.admin.')->prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'adminLoginView'])->name('login');
    Route::post('/login', [LoginController::class, 'adminLogin']);
});

/**
 * --------------------------------------------------------------------------
 * REGISTER ROUTES
 * --------------------------------------------------------------------------
 */

//  Student
Route::name('auth.student.')
    ->prefix('student')
    ->middleware(['guest', 'guest:teacher', 'guest:student'])
    ->group(function () {
        Route::get('/register', [RegisterController::class, 'studentRegisterView'])->name('register');
        Route::post('/register', [StudentController::class, 'store']);
    });

//  Teacher
Route::name('auth.teacher.')
    ->prefix('teacher')
    ->middleware(['guest', 'guest:teacher', 'guest:student'])
    ->group(function () {
        Route::get('/register', [RegisterController::class, 'teacherRegisterView'])->name('register');
        Route::post('/register', [TeacherController::class, 'store']);
    });

// ADMIN IS REGISTRED ON THE COMMAND LINE FOR SECURITY REASONS

/**
 * --------------------------------------------------------------------------
 * ADMIN ROUTES
 * --------------------------------------------------------------------------
 */

Route::get('/marks', [FocultyController::class, 'index']);

Route::name('admin.')->prefix('admin')->middleware(['auth:admin'])->group(function () {
    // DASHBOARD
    // Route::post('', [DashboardController::class, 'admin'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // RESOURCES
    Route::resource('student', StudentController::class);
    Route::resource('teacher', TeacherController::class);
    Route::resource('module', ModuleController::class);
    Route::resource('marks', MarkController::class);
    Route::resource('foculty', FocultyController::class);

    // STUDENT REGISTRATION
    Route::get('/student/reg/list', [RegistrationController::class, 'listStudents'])
        ->name('student.reg.list');
    Route::get('/student/reg/rejected', [RegistrationController::class, 'listRejectedStudents'])
        ->name('student.reg.rejected');
    Route::post('/student/{student}/reg/confirm', [RegistrationController::class, 'confirmStudent'])
        ->name('student.reg.confirm');
    Route::post('/student/{student}/reg/reject', [RegistrationController::class, 'rejectStudent'])
        ->name('student.reg.reject');
    Route::post('/student/{student}/reg/restore', [RegistrationController::class, 'restoreStudent'])
        ->name('student.reg.restore');


    // TEACHER REGISTRATION
    Route::get('/teacher/reg/list', [RegistrationController::class, 'listTeachers'])->name('teacher.reg.list');
    Route::get('/teacher/reg/rejected', [RegistrationController::class, 'listRejectedTeachers'])->name('teacher.reg.rejected');
    Route::post('/teacher/{teacher}/reg/confirm', [RegistrationController::class, 'confirmTeacher'])->name('teacher.reg.confirm');
    Route::post('/teacher/{teacher}/reg/reject', [RegistrationController::class, 'rejectTeacher'])->name('teacher.reg.reject');
    Route::post('/teacher/{teacher}/reg/restore', [RegistrationController::class, 'restoreTeacher'])->name('teacher.reg.restore');

    // ADMIN LOGOUT
    Route::post('/logout', [LogoutController::class, 'adminLogout'])->name('logout')->middleware('auth:admin');

    // Account
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::post('/account/personal', [AccountController::class, 'changePersonal'])->name('account.personal');
    Route::post('/account/email', [AccountController::class, 'changeEmail'])->name('account.email');
    Route::post('/account/password', [AccountController::class, 'changePassword'])->name('account.password');
});

/**
 * --------------------------------------------------------------------------
 * Teacher ROUTES
 * --------------------------------------------------------------------------
 */

Route::name('teacher.')->prefix('teacher')->middleware('auth:teacher')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // RESOURCES
    Route::get('/student/{student}', [StudentController::class, 'show'])->name('student.show');
    Route::get('/student', [StudentController::class, 'teacherStudents'])->name('student.index');
    Route::resource('module', ModuleController::class)->only(['show', 'index']);
    Route::resource('marks', MarkController::class);
    Route::resource('foculty', FocultyController::class)->only(['index', 'show']);
    Route::get('/account', [AccountController::class, 'index'])->name('account');

    // Account
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::post('/account/personal', [AccountController::class, 'changePersonal'])->name('account.personal');
    Route::post('/account/email', [AccountController::class, 'changeEmail'])->name('account.email');
    Route::post('/account/password', [AccountController::class, 'changePassword'])->name('account.password');

    // TEACHER LOGOUT
    Route::post('/logout', [LogoutController::class, 'teacherLogout'])->name('logout')->middleware('auth:teacher');
});

/**
 * --------------------------------------------------------------------------
 * Student ROUTES
 * --------------------------------------------------------------------------
 */

Route::name('student.')->middleware('auth:student')->prefix('student')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('teacher', TeacherController::class)->only(['show']);
    Route::resource('module', ModuleController::class)->only(['show', 'index']);
    Route::resource('marks', MarkController::class)->only(['index', 'show']);
    Route::resource('foculty', FocultyController::class)->only(['show']);
    // Account
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::post('/account/personal', [AccountController::class, 'changePersonal'])->name('account.personal');
    Route::post('/account/email', [AccountController::class, 'changeEmail'])->name('account.email');
    Route::post('/account/password', [AccountController::class, 'changePassword'])->name('account.password');


    Route::post('/logout', [LogoutController::class, 'studentLogout'])->name('logout')->middleware('auth:student');
});
