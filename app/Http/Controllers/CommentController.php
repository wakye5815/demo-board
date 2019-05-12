<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Http\Validators\CommentValidator;
use App\Http\ResponseBuilders\FailuerResponseBuilder;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $validator = new CommentValidator($request, 'board_id', 'content');
        if ($validator->fails()) $validator->sendFailuerResponse();

        Comment::create([
            'board_id' => $request->get('board_id'),
            'owner_user_id' => Auth::user()->id,
            'content' => $request->get('content')
        ]);

        return $this->createCommonResponse($request->get('board_id'));
    }

    public function delete(Request $request)
    {
        $validator = new CommentValidator($request, 'comment_id');
        if ($validator->fails()) $validator->sendFailuerResponse();

        $comment = Comment::find($request->get('comment_id'));

        if (is_null($comment)) {
            return $this->createNotExistsCommentResponse();
        } else {
            $comment->delete();
            return $this->createCommonResponse($comment->board_id);
        }
    }

    public function edit(Request $request)
    {
        $validator = new CommentValidator($request, 'comment_id', 'new_content');
        if ($validator->fails()) $validator->sendFailuerResponse();

        $comment = Comment::find($request->get('comment_id'));

        if (is_null($comment)) {
            return $this->createNotExistsCommentResponse();
        } else {
            $comment->update(['content' => $request->get('new_content')]);
            return $this->createCommonResponse($comment->board_id);
        }
    }

    public function find(Request $request)
    {
        $validator = new CommentValidator($request, 'comment_id');
        if ($validator->fails()) $validator->sendFailuerResponse();

        $comment = Comment::findOneById($request->get('comment_id'));

        return is_null($comment)
            ? $this->createNotExistsCommentResponse()
            : (new SuccessResponseBuilder())
            ->setContent(['comment' => $comment])
            ->build();
    }

    /**
     * CommentControllerでは更新後のボード内のコメントリストを返却
     *
     * @param [type] $boardId
     * @return \Illuminate\Http\JsonResponse
     */
    private function createCommonResponse($boardId)
    {
        $commentList = Comment::findListByBoardId($boardId);
        return (new SuccessResponseBuilder())
            ->setContent(['comment_list' => $commentList])
            ->build();
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
