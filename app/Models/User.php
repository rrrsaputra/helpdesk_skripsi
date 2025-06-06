<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Coderflex\LaravelTicket\Concerns\HasTickets;
use Coderflex\LaravelTicket\Contracts\CanUseTickets;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanUseTickets
{
    use HasFactory, Notifiable, HasTickets;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'study_program_id',
        'lecture_program',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function businessHours()
    {
        return $this->hasMany(BusinessHour::class);
    }

    // public function scheduledCalls()
    // {
    //     return $this->hasMany(ScheduledCall::class);
    // }

    public function StudyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }
}
