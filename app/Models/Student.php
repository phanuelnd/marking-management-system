<?php

namespace App\Models;

use App\Models\Mark;
use App\Models\Module;
use App\Models\Foculty;
use App\Scopes\ConfirmScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\MockObject\Builder\Stub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $guard = 'student';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'index_number',
        'name',
        'phone',
        'email',
        'password',
        'confirmed_at',
        'foculty_id'
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
     * Get unconfirmed students
     */
    public static function unconfirmed()
    {
        return Student::withoutGlobalScope(ConfirmScope::class)->where('confirmed_at', null);
    }

    /**
     * Get students related to a teacher
     */
    public static function taughtBy(int $teacher_id)
    {
        return Student::whereHas('foculty', function (Builder $query) use ($teacher_id) {
            $query->whereHas('modules', function (Builder $query) use ($teacher_id) {
                $query->where('teacher_id', '=', $teacher_id);
            });
        });
    }

    public function foculty()
    {
        return $this->belongsTo(Foculty::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public static function rejected()
    {
        return Student::onlyTrashed();
    }

    public static function booted()
    {
        static::addGlobalScope(new ConfirmScope);
    }

    public function getUserType()
    {
        $name = explode('\\', strtolower(__CLASS__));
        return end($name);
    }
}
