import Vue from "vue";
import Vuex from 'vuex';
import { User } from '../commonTypes'

Vue.use(Vuex);

export default new Vuex.Store({
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


