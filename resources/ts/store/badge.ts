import * as Vuex from 'vuex';
import { Badge } from "../commonTypes";
import { rootState } from '.';
import router from '../router';
import { fetchBadgeMaster } from '../api/badge';
import { isSuccessResponse } from '../api/utils';

export interface BadgeState {
    badgeMaster: Badge[],
    isInitialized: boolean
}

const getters = {
    badgeMaster: (state: BadgeState, _: any, rootState: rootState) => state.badgeMaster,
    selectedBadgeById: (state: BadgeState, _: any, rootState: rootState) =>
        (id: number) =>  {
            const result = state.badgeMaster.find(badge => badge.badge_id == id);
            if(typeof result == "undefined") throw new Error(`Not found badge_id(${id})`);
            return result;
        }
}

const state: BadgeState = {
    badgeMaster: [],
    isInitialized: false
}

const mutations = {
    initialize(state: BadgeState, payload: any) {
        state.badgeMaster = payload;
        state.isInitialized = true;
    }
}

const actions = {
    async initialize({ commit }: any, _: any){
        const response = await fetchBadgeMaster();
        if(isSuccessResponse(response)){
            commit("initialize", response.content.badge_master);
        }
    }
}

export default class BadgeModule implements Vuex.Module<BadgeState, any> {
    public namespaced = true;
    public state = state;
    public mutations = mutations;
    public getters = getters;
    public actions = actions;
}