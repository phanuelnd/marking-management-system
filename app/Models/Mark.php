<?php

namespace App\Models;

use App\Models\Module;
use App\Models\Student;
use App\Scopes\DeletedStudentScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'module_id',
        'marks',
        'semester',
        'teacher_id',
        'formative',
        'summative',
        'total',
        'decision',
        'academic_year'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public static function booted()
    {
        static::addGlobalScope(new DeletedStudentScope);
    }
}
