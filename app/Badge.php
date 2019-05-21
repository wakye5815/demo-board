<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    const BADGE_ID = [
        'TOP_USER' => 0,
        'ACTIVE_USER' => 1,
        'POPULAR_USER' => 2,
        'LONELY_USER' => 3,
        'BEGINNER' => 4
    ];

    protected $table = 'm_badges';

    protected $fillable = ['badge_id', 'name', 'description', 'priority'];    
}
