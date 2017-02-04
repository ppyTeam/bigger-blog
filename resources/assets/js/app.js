"use strict";

import Vue from 'vue';
import VueResource from 'vue-resource';
Vue.use(VueResource);


import '../sass/app.scss';
import NProgress from 'nprogress';
import hljs from 'highlight.js';
import router from './app-router';
import store from './store/index';


// Setting
Vue.http.options.emulateHTTP = true;
NProgress.configure({ showSpinner: false });


// 自定义高亮指令
Vue.directive('hljs', el => {
    let blocks = el.querySelectorAll('pre code');
    Array.prototype.forEach.call(blocks, hljs.highlightBlock);
});


// 拦截 Ajax 请求
Vue.http.interceptors.push((request, next) => {
    NProgress.start();

    // continue
    next(response => {
        if (!response.ok) {
            // TODO 留着
        }

        NProgress.done();
    });
});


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