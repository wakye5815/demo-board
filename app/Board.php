<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['name', 'owner_user_id'];

    public function ownerUser()
    {
        return $this->belongsTo('App\User', 'owner_user_id', 'id');
    }

    public static function findAll()
    {
        return Board::with('ownerUser')
            ->get();
    }

    public static function findOneById($id)
    {
        return Board::with('ownerUser')
            ->find($id);
    }
}
