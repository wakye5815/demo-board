import Vue from "vue";
import Vuex from 'vuex';
import CommentDialogModule from "./commentDialog"
import CommentDeleteDialogModule from "./commentDeleteDialog"
import { User } from '../commonTypes'

Vue.use(Vuex);

export interface rootState {
    isLoading: boolean,
    loginUser?: User
}

export default new Vuex.Store<rootState>({
    modules: {
        commentDialog: new CommentDialogModule(),
        commentDeleteDialog: new CommentDeleteDialogModule()
    },
    state: {
        isLoading: false,
        loginUser: undefined
    },
    mutations: {
        isLoading(state, payload) {
            state.isLoading = payload;
        },
        loginUser(state, payload) {
            state.loginUser = payload;
        },
    },
    actions: {},
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        loginUser(state): User | undefined {
            return state.loginUser;
        },
    },
    plugins: []
});


