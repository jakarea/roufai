<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bio',
        'payment_details',
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
     * Relationships for instructors
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    /**
     * Relationships for students
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrollmentRequests()
    {
        return $this->hasMany(EnrollmentRequest::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if user is an instructor
     */
    public function isInstructor(): bool
    {
        return $this->role === 'instructor';
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a student
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
}
