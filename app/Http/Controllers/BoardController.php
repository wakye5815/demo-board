<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Http\Validators\BoardValidator;
use App\Board;


class BoardController extends Controller
{
    public function create(Request $request)
    {
        $validator = new BoardValidator($request, 'name');
        if ($validator->fails()) $validator->sendFailuerResponse();

        Board::create([
            'name' => $request->get('name'),
            'owner_user_id' => Auth::user()->id
        ]);

        return (new SuccessResponseBuilder())
            ->setContent(['all_board_list' => Board::findAll()->toArray()])
            ->build();
    }

    public function all()
    {
        return (new SuccessResponseBuilder())
            ->setContent(['all_board_list' => Board::findAll()->toArray()])
            ->build();
    }

    public function top(Request $request)
    {
        $validator = new BoardValidator($request, 'board_id');
        if ($validator->fails()) $validator->sendFailuerResponse();

        $board = Board::findOneById($request->get('board_id'))->toArray();

        return is_null($board)
            ? (new FailuerResponseBuilder())
            ->setSystemErrorList(['指定されたボードが見つかりませんでした。'])
            ->build()
            : (new SuccessResponseBuilder())
            ->setContent([
                'board' => $board,
                'comment_list' => \App\Comment::findListByBoardId($request->get('board_id'))
            ])
            ->build();
    }
}
