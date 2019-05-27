<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
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

    protected $appends = ['badge_id'];

    public function getBadgeIdAttribute()
    {
        $badge = $this->badge_list->first();
        return is_null($badge) ? null : $badge->badge_id;
    }

    public function comment()
    {
        return $this->hasMany('App\Models\Comment', 'owner_user_id', 'id');
    }

    public function board()
    {
        return $this->hasMany('App\Models\Board', 'owner_user_id', 'id');
    }

    public function badge_list()
    {
        return $this->belongsToMany(
            'App\Models\Badge',
            'user_badges',
            'user_id',
            'badge_id'
        );
    }

    public static function isUniqueEmail(string $email)
    {
        return DB::table('users')
            ->select('*')
            ->where('users.email', $email)
            ->count() == 0;
    }

    public static function hasBadgeInBoard($userId, $boardId)
    {
        return DB::table('user_badges')
            ->where('user_id', '=', $userId)
            ->where('board_id', '=', $boardId)
            ->count() == 1;
    }

    /**
     * Undocumented function
     *
     * @param [type] $boardId
     * @return Model
     */
    public static function findListInBoard($boardId)
    {
        return User::with([
            'board' => function ($query) use ($boardId) {
                $query->where('id', '=', $boardId);
            }
        ])
            ->get();
    }
}
