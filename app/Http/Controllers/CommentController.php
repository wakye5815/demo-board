<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Http\Validators\CommentValidator;
use App\Http\ResponseBuilders\FailuerResponseBuilder;
use App\Services\CommentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentController extends Controller
{
    /**
     * @var CommentService
     */
    private $commentService = null;

    public function __construct(CommentService $commentService)
    {
        $this->middleware('auth');
        $this->commentService = $commentService;
    }

    public function create(Request $request)
    {
        $validator = new CommentValidator($request, 'board_id', 'content');
        if ($validator->fails()) $validator->sendFailuerResponse();

        $this->commentService->create(
            $request->get('board_id'),
            Auth::user()->id,
            $request->get('content')
        );

        return (new SuccessResponseBuilder())->build();
    }

    public function delete(Request $request)
    {
        $validator = new CommentValidator($request, 'comment_id');
        if ($validator->fails()) $validator->sendFailuerResponse();

        try {
            $this->commentService->delete($request->get('comment_id'));
            return (new SuccessResponseBuilder())->build();
        } catch (ModelNotFoundException $e) {
            return $this->createNotExistsCommentResponse();
        }
    }

    public function edit(Request $request)
    {
        $validator = new CommentValidator($request, 'comment_id', 'new_content');
        if ($validator->fails()) $validator->sendFailuerResponse();

        try {
            $this->commentService->update($request->get('comment_id'), $request->get('new_content'));
            return (new SuccessResponseBuilder())->build();
        } catch (ModelNotFoundException $e) {
            return $this->createNotExistsCommentResponse();
        }
    }

    public function find(Request $request)
    {
        $validator = new CommentValidator($request, 'comment_id');
        if ($validator->fails()) $validator->sendFailuerResponse();

        try {
            $comment = $this->commentService
                ->findOneById($request->get('comment_id'))
                ->toArray();

            return (new SuccessResponseBuilder())
                ->setContent(['comment' => $comment])
                ->build();
        } catch (ModelNotFoundException $e) {
            return $this->createNotExistsCommentResponse();
        }
    }

    public function reply(Request $request)
    {
        $validator = new CommentValidator($request, 'content', 'to_comment_id');
        if ($validator->fails()) $validator->sendFailuerResponse();

        try {
            $this->commentService->createReply(
                $request->get('to_comment_id'),
                Auth::user()->id,
                $request->get('content')
            );

            return (new SuccessResponseBuilder())->build();
        } catch (ModelNotFoundException $e) {
            return $this->createNotExistsCommentResponse();
        }
    }

    /**
     * 指定コメントが存在しない場合のレスポンス
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function createNotExistsCommentResponse()
    {
        return (new FailuerResponseBuilder())
            ->setSystemErrorList(['指定されたコメントが見つかりませんでした。'])
            ->build();
    }
}
