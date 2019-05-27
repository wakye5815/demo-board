<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Board;

class BoardService
{
    public function create($name, $ownerUserId){
        return Board::create([
            'name' => $name,
            'owner_user_id' => $ownerUserId
        ]);
    }

    public function findAll(){
        return Board::findAll();
    }

    public function findOneById($id){
        $result = Board::findOneById($id);
        if(is_null($result)) throw new ModelNotFoundException();
        return $result;
    }

    public function findIdByCommentId($commentId){
        return Comment::findOrFail($commentId)->id;
    }
}
