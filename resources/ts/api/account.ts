import httpClient from './httpClient';
import * as types from './types'
import { User } from '../commonTypes'

namespace AccountApiUrl {
    export const SIGNIN = '/api/account/signin';
    export const SIGNUP = '/api/account/signup';
    export const SIGNOUT = '/api/account/signout';
}


type AccountApiResponse = types.SuccessApiResponse<{ user: User }>;

type SignupRequestParams = { name: string, signup_email: string, password: string };
export async function signup(params: SignupRequestParams):
    Promise<AccountApiResponse | types.FailuerApiResponse<SignupRequestParams>> {
    return await httpClient
        .post(AccountApiUrl.SIGNUP, params);
}

type SigninRequestParams = { signin_email: string, password: string };
export async function signin(params: SigninRequestParams)
    : Promise<AccountApiResponse | types.FailuerApiResponse<SigninRequestParams>> {
    return await httpClient
        .post(AccountApiUrl.SIGNIN, params);
}

export async function signout(){
    return await httpClient.get(AccountApiUrl.SIGNOUT);
}