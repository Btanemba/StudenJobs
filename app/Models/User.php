<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use CrudTrait;
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'created_by',
        'updated_by',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::created(function ($user) {
            // Only set created_by if an authenticated user exists
            if (Auth::check()) {
                $user->created_by = Auth::id();
                $user->saveQuietly(); // Avoid triggering updating event
            }

            // Automatically create a person record
            //$user->person()->create([]);
        });

        static::updating(function ($user) {
            // Only set updated_by if an authenticated user exists
            if (Auth::check()) {
                $user->updated_by = Auth::id();
            }
        });

        static::deleting(function ($user) {
        // Delete the related person if it exists
        if ($user->person) {
            $user->person->delete();
        }
    });
    }

    public function person()
    {
        return $this->hasOne(Person::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->administrator()->exists();
    }

    public function administrator()
    {
        return $this->hasOne(\App\Models\Administrator::class, 'id');
    }


}
