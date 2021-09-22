<?php

namespace App\Models;

use App\Models\Mark;
use App\Models\Module;
use App\Models\Foculty;
use App\Scopes\ConfirmScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $guard = 'teacher';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'confirmed_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get unconfirmed teachers
     */
    public static function unconfirmed()
    {
        return Teacher::withoutGlobalScope(ConfirmScope::class)->where('confirmed_at', null);
    }

    public static function rejected()
    {
        return Teacher::onlyTrashed()->all();
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function marks()
    {
        return $this->hasManyThrough(Mark::class, Module::class);
    }

    public static function booted()
    {
        static::addGlobalScope(new ConfirmScope);
    }

    public static function hasStudent(int $student_id)
    {
        return Teacher::whereHas('modules', function (Builder $query) use ($student_id) {
            $query->whereHas('foculty', function (Builder $query) use ($student_id) {
                $query->whereHas('students', function (Builder $query) use ($student_id) {
                    $query->where('id', $student_id);
                });
            });
        });
    }
}
