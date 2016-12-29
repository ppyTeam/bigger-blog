"use strict";

import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);
// import Vuex from 'vuex';
// Vue.use(Vuex);
import VueResource from 'vue-resource';
Vue.use(VueResource);
require('../sass/app.scss');


// root
new Vue({
    el: '#app',
    router: new VueRouter(require('./app-router')),
    created: function () {
        const d = document,
            htmlSEOContainer = d.getElementById('html-seo-container');

        let contentEle = htmlSEOContainer.querySelector('content'),
            content = contentEle && contentEle.innerHTML || '';

        htmlSEOContainer.parentNode.removeChild(htmlSEOContainer);


        // LocalStorage Test
        console.timeEnd('lsload');
    }
});