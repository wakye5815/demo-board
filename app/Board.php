<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Board extends Model
{
    protected $fillable = ['name', 'owner_user_id'];

    public static function findAll()
    {
        return DB::table('boards')
            ->select(
                'boards.id',
                'boards.name',
                'users.name as owner_name',
                'boards.created_at',
                'boards.updated_at'
            )
            ->join('users', 'boards.owner_user_id', '=', 'users.id')
            ->get();
    }

    public static function findOneById($id)
    {
        return DB::table('boards')
            ->select(
                'boards.id',
                'boards.name',
                'users.name as owner_name',
                'boards.created_at',
                'boards.updated_at'
            )
            ->join('users', 'boards.owner_user_id', '=', 'users.id')
            ->where('boards.id', $id)
            ->first();
    }
}
