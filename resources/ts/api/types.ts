export namespace ApiStatus {
    export const ERROR = 0;
    export const FAILUER = 1;
    export const SUCCESS = 2;
}

export type ApiResponse<T> = {
    status: 0 | 1 | 2;
    content: T;
};

export type SuccessApiResponse<T> = ApiResponse<T>;

export type FailuerApiResponse<T> = ApiResponse<Partial<{
    param_error_list: Partial<{ [P in keyof T]: string[] }>,
    system_error_list: string[]
}>
>;