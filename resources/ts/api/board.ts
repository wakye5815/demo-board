import httpClient from './httpClient';
import * as types from './types'
import { Board, Comment } from '../commonTypes'

namespace BoardApiUrl {
    export const CREATE = '/api/board/create';
    export const ALL = '/api/board/all';
    export const TOP = '/api/board/top';
}

type BoardApiResponse<T> =
    types.SuccessApiResponse<{ all_board_list: Board[] }> | types.FailuerApiResponse<T>;

export async function createBoard(params: { name: string }): Promise<BoardApiResponse<{ name: string }>> {
    return await httpClient
        .post(BoardApiUrl.CREATE, params);
}


export async function fetchAllBoard(): Promise<BoardApiResponse<{}>> {
    return await httpClient.get(BoardApiUrl.ALL);
}

type BoardTopApiResponse =
    types.SuccessApiResponse<{ board: Board, comment_list: Comment[] }> | types.FailuerApiResponse<{ board_id: number }>;
export async function fetchBoardTop(params: { board_id: number }): Promise<BoardTopApiResponse> {
    return await httpClient.get(BoardApiUrl.TOP, params);
}