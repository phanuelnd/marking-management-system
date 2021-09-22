<?php

namespace App\Providers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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

        View::share('student_confirm_count', Student::unconfirmed()->count());
        View::share('teacher_confirm_count', Teacher::unconfirmed()->count());
    }
}
