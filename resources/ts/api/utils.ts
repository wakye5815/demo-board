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

export function extractErrorMessageList<T>(response: types.FailuerApiResponse<T>) {
    const paramErrorMessageList =
        typeof response.content.param_error_list != "undefined"
            ? Object.keys(response.content.param_error_list)
                .map(keys => (response.content.param_error_list as any)[keys])
                .reduce((acc: string[], next: string[]) => [...acc, ...next])
            : [];
    const systemErrorList =
        typeof response.content.system_error_list != "undefined"
            ? Object.keys(response.content.system_error_list)
                .map(keys => (response.content.system_error_list as any)[keys])
                .reduce((acc: string[], next: string[]) => [...acc, ...next])
            : [];
    return [...paramErrorMessageList, ...systemErrorList];
}