<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
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
        'username',
        'foto_guru',
        'password',
        'last_activity',
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
            'last_activity' => 'datetime',
        ];
    }

    /**
     * Check if user is online
     */
    public function isOnline()
    {
        if (!$this->last_activity) {
            return false;
        }

        return Carbon::parse($this->last_activity)->gt(Carbon::now()->subMinutes(2));
    }

    /**
     * Get user initials for avatar
     */
    public function getInitials()
    {
        $nameParts = explode(' ', $this->name);
        $initials = '';

        if (count($nameParts) >= 2) {
            $initials = strtoupper(substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1));
        } else {
            $initials = strtoupper(substr($this->name, 0, 2));
        }

        return $initials;
    }

    /**
     * Get random background color for avatar
     */
    public function getAvatarColor()
    {
        $colors = [
            'bg-pink-500',
            'bg-purple-500',
            'bg-indigo-500',
            'bg-blue-500',
            'bg-teal-500',
            'bg-green-500',
            'bg-yellow-500',
            'bg-orange-500',
            'bg-red-500',
            'bg-rose-500'
        ];

        // Use user ID to get consistent color
        return $colors[$this->id % count($colors)];
    }
}
