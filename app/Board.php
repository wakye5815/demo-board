<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Board extends Model
{
    protected $fillable = ['name', 'owner_user_id'];

    private static $usersJoinColumns = [
        'boards.id',
        'boards.name',
        'users.name as owner_name',
        'boards.created_at',
        'boards.updated_at'
    ];

    public static function findAll()
    {
        return DB::table('boards')
            ->select(Board::$usersJoinColumns)
            ->join('users', 'boards.owner_user_id', '=', 'users.id')
            ->get();
    }

    public static function findOneById($id)
    {
        return DB::table('boards')
            ->select(Board::$usersJoinColumns)
            ->join('users', 'boards.owner_user_id', '=', 'users.id')
            ->where('boards.id', $id)
            ->first();
    }
}
