<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    /**
     * Get the role associated with the user.
     */
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isTrainer(): bool
    {
        return $this->hasRole('trainer');
    }

    public function isAthlete(): bool
    {
        return $this->hasRole('athlete');
    }

    /**
     * Get athletes assigned to this trainer.
     */
    public function athletes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'trainer_athletes', 'trainer_id', 'athlete_id')
                    ->withPivot('assigned_at')
                    ->withTimestamps();
    }

    /**
     * Get trainers assigned to this athlete.
     */
    public function trainers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'trainer_athletes', 'athlete_id', 'trainer_id')
                    ->withPivot('assigned_at')
                    ->withTimestamps();
    }

    /**
     * Get the workout plans created by this user.
     */
    public function workoutPlans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WorkoutPlan::class, 'creator_id');
    }

    /**
     * Get the workouts performed by this user.
     */
    public function workouts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Workout::class);
    }

    /**
     * Get the relative dashboard route based on user role.
     */
    public function dashboardRoute(): string
    {
        if ($this->isAdmin()) {
            return route('admin.dashboard', absolute: false);
        }
        if ($this->isTrainer()) {
            return route('trainer.dashboard', absolute: false);
        }
        return route('dashboard', absolute: false);
    }
}
