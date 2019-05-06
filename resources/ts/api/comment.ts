import httpClient from './httpClient';
import * as types from './types'
import { Comment } from '../commonTypes'

namespace CommentApiUrl {
    export const CREATE = '/api/comment/create';
    export const DELETE = '/api/comment/delete';
    export const EDIT = '/api/comment/edit';
    export const FIND = '/api/comment/find';
}


type CommentApiResponse<T> = types.SuccessApiResponse<{ comment_list: Comment[] }> | types.FailuerApiResponse<T>;

type CreateRequestParams = { board_id: number, content: string };
export async function createComment(params: CreateRequestParams)
    : Promise<CommentApiResponse<CreateRequestParams>> {
    return await httpClient.post(CommentApiUrl.CREATE, params);
}


export async function deleteComment(params: { comment_id: number })
    : Promise<CommentApiResponse<{ comment_id: number }>> {
    return await httpClient.delete(CommentApiUrl.DELETE, params);
}

export async function editComment(params: { comment_id: number, new_content: string })
    : Promise<CommentApiResponse<{ comment_id: number, new_content: string }>> {
    return await httpClient.patch(CommentApiUrl.EDIT, params);
}

export async function fetchCommentById(params: { comment_id: number })
    : Promise<types.SuccessApiResponse<{ comment: Comment }> | types.FailuerApiResponse<{ comment_id: number }>> {
    return await httpClient.get(CommentApiUrl.FIND, params);
}