"use strict";

import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);


import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';


const state = {

};


export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    state,
    actions,
    mutations,
    getters
});