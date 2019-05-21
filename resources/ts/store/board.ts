import * as Vuex from 'vuex';
import { Comment, Board } from "../commonTypes";
import { fetchBoardTop } from "../api/board";
import { isSuccessResponse } from '../api/utils';

export interface BoardState {
    board?: Board,
    commentList: Comment[]
}

const state: BoardState = {
    board: undefined,
    commentList: []
}

const mutations = {
    initialize(state: BoardState, payload: any) {
        state.board = payload.board;
        state.commentList = payload.comment_list;
    },
    update(state: BoardState, payload: any) {
        state.commentList = payload;
    }
}

const actions = {
    async initialize({ commit }: any, payload: any) {
        const response = await fetchBoardTop({ board_id: payload });
        if (isSuccessResponse(response)) {
            commit("initialize", response.content);
        }
    },

    async update({state, commit }: any, payload: any) {
        const response = await fetchBoardTop({ board_id: state.board.id });
        if (isSuccessResponse(response)) {
            commit("update", response.content.comment_list);
        }
    }
}

export class BoardModule implements Vuex.Module<BoardState, any> {
    public namespaced = true;
    public state = state;
    public actions = actions;
    public mutations = mutations;
}

export function createBoardModule() {
    return new BoardModule();
}


