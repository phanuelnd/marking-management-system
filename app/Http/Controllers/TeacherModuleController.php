<?php

namespace App\Http\Controllers;

use App\Models\Foculty;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TeacherModuleController extends Controller
{
    public function index(Teacher $teacher)
    {
        return response($teacher->modules()->paginate(20));
    }

    public function getDepartments(Teacher $teacher)
    {
        return [];
    }
}
