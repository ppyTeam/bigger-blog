"use strict";

import Vue from 'vue';
import VueRouter from 'vue-router';
// import Vuex from 'vuex';

require('../sass/app.scss');

// Vue.use
// Vue.use(Vuex);
Vue.use(VueRouter);

// root
new Vue({
    el: '#app',
    router: new VueRouter(require('./app-router')),
    created: function () {
        const d = document,
            htmlSEOContainer = d.getElementById('html-seo-container');

        let contentEle = htmlSEOContainer.querySelector('content'),
            content = contentEle && contentEle.innerHTML || '';
        console.log(content);

        htmlSEOContainer.parentNode.removeChild(htmlSEOContainer);
    }
});
