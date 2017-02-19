"use strict";

import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);


import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';


const state = {
    navHeaderState: true, // 展开为 true，收缩为 false
    navData: { },
    data: { }, // 所有缓存的数据保存在此
    blogContent: ''
};


export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    state,
    actions,
    mutations,
    getters
});