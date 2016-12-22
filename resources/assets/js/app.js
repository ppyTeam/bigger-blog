"use strict";

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';


require('../sass/app.scss');

Vue.use(VueRouter);
Vue.use(Vuex);


Vue.component('my-example', require('./components/Example.vue'));
Vue.component('my-nav', require('./components/navigation.vue'));

const root = new Vue({
    el: '#app',
    template: '<div><my-nav></my-nav></div>'
});
