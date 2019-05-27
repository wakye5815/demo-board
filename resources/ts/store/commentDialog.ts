import * as Vuex from 'vuex';
import { Comment } from "../commonTypes";
import { rootState } from '.';

export interface CommentDialogState {
    comment?: Comment,
    canDisplay: boolean
}

const getters = {
    isMine: (state: CommentDialogState, _: any, rootState: rootState) =>
        typeof rootState.loginUser != "undefined"
            ? typeof state.comment != "undefined"
                ? state.comment.owner_user.id == rootState.loginUser.id
                : false
            : false


}

const state: CommentDialogState = {
    comment: undefined,
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