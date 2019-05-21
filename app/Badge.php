<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    const BADGE_ID = [        
        'BEGINNER' => 0,
        'ACTIVE_USER' => 1,
        'POPULAR_USER' => 2,
        'LONELY_USER' => 3,
        'TOP_USER' => 4
    ];

    protected $table = 'm_badges';

    protected $fillable = ['badge_id', 'name', 'description', 'priority'];

    public function user(){
        return $this->hasMany('App\User', 'badge_id', 'badge_id');
    }
}
