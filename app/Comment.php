<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['board_id', 'owner_user_id', 'content'];

    public function ownerUser()
    {
        return $this->belongsTo('App\User', 'owner_user_id', 'id');
    }

    public static function findListByBoardId($id)
    {
        return Comment::with('ownerUser')
            ->where('board_id', $id)
            ->get();
    }

    public static function findOneById($id)
    {
        return Comment::with('ownerUser')
            ->find($id);
    }
}
