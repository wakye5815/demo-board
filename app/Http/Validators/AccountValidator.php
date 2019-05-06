<?php
namespace App\Http\Validators;

use App\User;

class AccountValidator extends BaseValidator
{
    protected function validatableParams()
    {
        return collect([
            'signin_email',
            'signup_email',
            'password',
            'name',

        ]);
    }

    protected function rules()
    {
        return collect([
            'signin_email' => ['required', 'string'],
            'signup_email' => [
                'required',
                'string',
                'email',
                function ($attribute, $value, $fail) {
                    if (!User::isUniqueEmail($value))
                        return $fail("既に使用されているメールアドレスです。");
                }
            ],
            'password' => ['required', 'string', 'min:8'],
            'name' => ['required', 'string', 'max:255']
        ]);
    }

    protected  function messages()
    {
        return collect([
            'signin_email' => [
                'required' => 'メールアドレスを入力してください。',
                'string' => 'メールアドレスが不正です。'
            ],
            'signup_email' => [
                'required' => 'メールアドレスを入力してください。',
                'string' => 'メールアドレスが不正です。',
                'email' => 'メールアドレスのフォーマットが不正です。'
            ],
            'password' => [
                'required' => 'パスワードを入力してください。',
                'string' => 'パスワードが不正です。',
                'min' => 'パスワードは最低8文字です。'
            ],
            'name' =>  [
                'required' => '名前を入力してください。',
                'string' => '名前が不正です。',
                'max' => '名前は最大255文字です。'
            ]
        ]);
    }
}
