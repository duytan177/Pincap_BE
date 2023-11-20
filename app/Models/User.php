<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Enums\User\Role;
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens,HasUlids, HasFactory, Notifiable;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    //cusstom payload
    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
            'name' => $this->firstName.' '. $this->lastName,
            'role' => $this->role
        ];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table= 'users';
    protected $fillable = [
        'id',
        'firstName',
        'lastName',
        'email',
        'password',
        'role'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRoleAttribute($value){
        return $value=='0'?'ADMIN':'USER';
    }

    public function albums(){
        return $this->belongsToMany(Album::class,"user_album")->withPivot('isUserOwner')->withTimestamps();
    }
}
