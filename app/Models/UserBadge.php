<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    protected $fillable = ['user_id', 'board_id', 'badge_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function board()
    {
        return $this->belongsTo('App\Models\Board', 'board_id', 'id');
    }

    public function badge()
    {
        return $this->belongsTo('App\Models\Badge', 'badge_id', 'badge_id');
    }
}
