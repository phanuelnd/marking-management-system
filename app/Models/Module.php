<?php

namespace App\Models;

use App\Models\Mark;
use App\Models\Foculty;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'foculty_id', 'teacher_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function foculty()
    {
        return $this->belongsTo(Foculty::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public static function hasStudent(int $student_id)
    {
        return Module::whereHas('foculty', function (Builder $query) use ($student_id) {
            $query->whereHas('students', function (Builder $query) use ($student_id) {
                $query->where('id', $student_id);
            });
        });
    }
}
