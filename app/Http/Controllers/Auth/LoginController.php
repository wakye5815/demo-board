<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\ResponseBuilders\FailuerResponseBuilder;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Http\Validators\AccountValidator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function signin(Request $request)
    {
        // signinとsignupでvalidationをemailを別名にすることで分けているため
        // emailにsignin_emailをコピー
        $request->merge([
            'email' => $request->get('signin_email')
        ]);
        return $this->login($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throw HttpResponseException
     */
    protected function validateLogin(Request $request)
    {
        $validator = new AccountValidator($request, 'signin_email', 'password');
        if ($validator->fails()) $validator->sendFailuerResponse();
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     *
     * @throw HttpResponseException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $response = (new FailuerResponseBuilder())
            ->setSystemErrorList(['メールアドレスもしくはパスワードが間違っています。'])
            ->build();

        throw new HttpResponseException($response);
    }

    protected function authenticated(Request $request, $user)
    {
        return (new SuccessResponseBuilder())
            ->setContent(['user' => $user])
            ->build();
    }

    protected function loggedOut(Request $request)
    {
        $request->session()->regenerate();
        return (new SuccessResponseBuilder())
            ->build();
    }
}
