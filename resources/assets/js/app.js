"use strict";

const Vue = require('vue'),
    VueRouter = require('vue-router'),
    Vuex = require('vuex');

require('../sass/app.scss');

Vue.use(VueRouter);
Vue.use(Vuex);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('my-example', require('./components/Example.vue'));
Vue.component('my-nav', require('./components/navigation.vue'));

const root = new Vue({
    el: '#app',
    template: '<div><my-nav></my-nav></div>'
});
