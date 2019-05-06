<?php
namespace App\Http\Validators;

class BoardValidator extends BaseValidator
{
    protected function validatableParams()
    {
        return collect([
            'name',
            'board_id'
        ]);
    }

    protected function rules()
    {
        return collect([
            'name' => ['required', 'string', 'max:255'],
            'board_id' => ['required', 'numeric']
        ]);
    }

    protected  function messages()
    {
        return collect([
            'name' => [
                'required' => '名前は必須パラメータです',
                'string' => '名前が文字列ではありません',
                'max' => '名前は最大255文字までです'
            ],
            'board_id' => [
                'required' => 'board_idは必須パラメータです',
                'numeric' => 'board_idが数値ではありません'
            ]
        ]);
    }
}