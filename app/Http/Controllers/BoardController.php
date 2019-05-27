<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Http\Validators\BoardValidator;
use App\Services\CommentService;
use App\Services\BoardService;

class BoardController extends Controller
{
    /**
     * @var CommentService
     */
    private $commentService = null;

    /**
     * @var BoardService
     */
    private $boardService = null;

    public function __construct(
        CommentService $commentService,
        BoardService $boardService
    ) {
        $this->commentService = $commentService;
        $this->boardService = $boardService;
    }

    public function create(Request $request)
    {
        $validator = new BoardValidator($request, 'name');
        if ($validator->fails()) $validator->sendFailuerResponse();

        $this->boardService->create($request->get('name'), Auth::user()->id);

        return (new SuccessResponseBuilder())
            ->setContent([
                'all_board_list' => $this->boardService->findAll()->toArray()
            ])
            ->build();
    }

    public function all()
    {
        return (new SuccessResponseBuilder())
            ->setContent([
                'all_board_list' => $this->boardService->findAll()->toArray()
            ])
            ->build();
    }

    public function top(Request $request)
    {
        $validator = new BoardValidator($request, 'board_id');
        if ($validator->fails()) $validator->sendFailuerResponse();

        try {
            return (new SuccessResponseBuilder())
                ->setContent([
                    'board' => $this->boardService
                        ->findOneById($request->get('board_id'))
                        ->toArray(),
                    'comment_list' => $this->commentService
                        ->findListByBoardId($request->get('board_id'))
                        ->toArray()
                ])
                ->build();
        } catch (ModelNotFoundException $e) {
            return (new FailuerResponseBuilder())
                ->setSystemErrorList(['指定されたボードが見つかりませんでした。'])
                ->build();
        }
    }
}
