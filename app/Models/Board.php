<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Board extends Model
{
    protected $fillable = ['name', 'owner_user_id'];

    public function ownerUser()
    {
        return $this->belongsTo('App\Models\User', 'owner_user_id', 'id');
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

    public static function findMostActiveUserInBoard($id)
    {
        return DB::table('comments')
            ->select(DB::raw('count(*) as comment_count, owner_user_id'))
            ->where('board_id', '=', $id)
            ->groupBy('owner_user_id')
            ->orderBy('comment_count', 'desc')
            ->first()->owner_user_id;
    }
}
