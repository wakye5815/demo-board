import Vue from "vue";
import Vuex from 'vuex';
import CommentDialogModule from "./commentDialog"
import CommentDeleteDialogModule from "./commentDeleteDialog"
import BadgeModule from "./badge"
import { User } from '../commonTypes'

Vue.use(Vuex);

const modules = {
    commentDialog: new CommentDialogModule(),
    commentDeleteDialog: new CommentDeleteDialogModule(),
    badge: new BadgeModule()
}

type moduleState = Partial<{ [P in keyof typeof modules]: any }>

export type rootState = {
    isLoading: boolean,
    loginUser?: User
} & moduleState

export default new Vuex.Store<rootState>({
    modules: modules,
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


