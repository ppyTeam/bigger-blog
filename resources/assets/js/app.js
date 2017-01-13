"use strict";

import Vue from 'vue';
import VueResource from 'vue-resource';
Vue.use(VueResource);


import * as scss from '../sass/app.scss';
import router from './app-router';
import store from './store/store';


Vue.http.options.emulateHTTP = true;


// root
new Vue({
    el: '#app',
    router,
    store,
    created: function () {
        const d = document,
            htmlSEOContainer = d.getElementById('html-seo-container');

        let contentEle = htmlSEOContainer.querySelector('#content'),
            content = contentEle && contentEle.innerHTML || '';

        htmlSEOContainer.parentNode.removeChild(htmlSEOContainer);
    }
});