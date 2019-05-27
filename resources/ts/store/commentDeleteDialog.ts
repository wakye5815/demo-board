import * as Vuex from 'vuex';
import { Comment } from "../commonTypes";

export interface CommentDeleteDialogState {
    comment?: Comment,
    canDisplay: boolean
}

const state: CommentDeleteDialogState = {
    comment: undefined,
    canDisplay: false
}

const mutations = {
    comment(state: CommentDeleteDialogState, payload: any) {
        state.comment = payload;
    },
    canDisplay(state: CommentDeleteDialogState, payload: any) {
        state.canDisplay = payload;
    }
}

export default class CommentDeleteDialogModule implements Vuex.Module<CommentDeleteDialogState, any> {
    public namespaced = true;
    public state = state;
    public mutations = mutations;
}