import * as Vuex from 'vuex';
import { Comment } from "../commonTypes";
import { rootState } from '.';

export interface CommentDialogState {
    comment: Comment,
    canDisplay: boolean
}

const getters = {
    isMine: (state: CommentDialogState, _: any, rootState: rootState) =>
        typeof rootState.loginUser != "undefined"
            ? state.comment.owner_id == rootState.loginUser.id
            : false
}

const state: CommentDialogState = {
    comment: {
        comment_id: 0,
        board_id: 0,
        content: "",
        owner_id: 0,
        owner_name: "",
        created_at: "",
        updated_at: ""
    },
    canDisplay: false
}

const mutations = {
    comment(state: CommentDialogState, payload: any) {
        state.comment = payload;
    },
    canDisplay(state: CommentDialogState, payload: any) {
        state.canDisplay = payload;
    }
}

export default class CommentDialogModule implements Vuex.Module<CommentDialogState, any> {
    public namespaced = true;
    public state = state;
    public mutations = mutations;
    public getters = getters;
}