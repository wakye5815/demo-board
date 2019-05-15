<?php
namespace App\Http\Validators;

class CommentValidator extends BaseValidator
{
    protected function validatableParams()
    {
        return collect([
            'board_id',
            'content',
            'new_content',
            'comment_id'
        ]);
    }

    protected function rules()
    {
        return collect([
            'board_id' => ['required', 'numeric'],
            'content' => ['required', 'string', 'max:255'],
            'new_content' => ['required', 'string', 'max:255'],
            'comment_id' => ['required', 'numeric']
        ]);
    }

    protected  function messages()
    {
        return collect([
            'board_id' => [
                'required' => 'board_idは必須パラメータです',
                'numeric' => 'board_idが数値ではありません'
            ],
            'content' => [
                'required' => 'contentは必須パラメータです',
                'string' => 'コメントが文字列ではありません',
                'max' => 'コメントは最大255文字までです'
            ],
            'new_content' => [
                'required' => 'new_contentは必須パラメータです',
                'string' => 'コメントが文字列ではありません',
                'max' => 'コメントは最大255文字までです'
            ],
            'comment_id' => [
                'required' => 'comment_idは必須パラメータです',
                'numeric' => 'comment_idが数値ではありません'
            ]
        ]);
    }
}