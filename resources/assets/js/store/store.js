"use strict";

import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);


import * as actions from './actions';
import * as mutations from './mutations';


export default new Vuex.Store({
    state: {

    },
    actions,
    mutations
});