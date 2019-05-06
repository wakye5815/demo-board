<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Validators\AccountValidator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\ResponseBuilders\SuccessResponseBuilder;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Undocumented function
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function signup(Request $request)
    {
        $validator = new AccountValidator($request, 'name', 'signup_email', 'password');
        if ($validator->fails()) $validator->sendFailuerResponse();

        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);

        return (new SuccessResponseBuilder())
            ->setContent(['user' => $user])
            ->build();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['signup_email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
