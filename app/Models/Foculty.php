<?php

namespace App\Models;

use App\Models\Module;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Foculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    // public static function whereHasTeacher(int $id)
    // {
    //     // return Foculty::
    // }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public static function hasTeacher(int $teacher_id) {
        return Foculty::whereHas(
            'modules',
            function ($query) use ($teacher_id) {
                $query->where('teacher_id', $teacher_id);
            }
        );
    }
}
