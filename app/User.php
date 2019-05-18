<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comment(){
        return $this->hasMany('App\Comment', 'owner_user_id', 'id');
    }

    public function board(){
        return $this->hasMany('App\Board', 'owner_user_id', 'id');
    }

    public static function isUniqueEmail(string $email)
    {
        return DB::table('users')
            ->select('*')
            ->where('users.email', $email)
            ->count() == 0;
    }
}
