import * as types from './types'

export function isSuccessResponse<T, U>
    (response: types.SuccessApiResponse<T> | types.FailuerApiResponse<U>)
    : response is types.SuccessApiResponse<T> {
    return response.status == types.ApiStatus.SUCCESS;
}

export function isFailuerResponse<T, U>
    (response: types.SuccessApiResponse<T> | types.FailuerApiResponse<U>)
    : response is types.FailuerApiResponse<U> {
    return response.status == types.ApiStatus.FAILUER;
}