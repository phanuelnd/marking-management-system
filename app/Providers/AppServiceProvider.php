<?php

namespace App\Providers;

use App\Models\Student;
use App\Models\Teacher;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        try {

            View::share('student_confirm_count', Student::unconfirmed()->count());
            View::share('teacher_confirm_count', Teacher::unconfirmed()->count());
        } catch (Exception $e) {
        }
    }
}
