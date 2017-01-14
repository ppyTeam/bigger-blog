"use strict";

import Vue from 'vue';
import VueResource from 'vue-resource';
Vue.use(VueResource);


import * as scss from '../sass/app.scss';
import router from './app-router';
import store from './store/index';


Vue.http.options.emulateHTTP = true;


// root
new Vue({
    el: '#app',
    router,
    store,
    created () {
        this.$store.commit('initNavData'); // 初始化导航数据
        this.$store.commit('initBlogContent'); // 初始化文章正文
    }
});