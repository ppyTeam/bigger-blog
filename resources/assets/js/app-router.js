import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);


import homeVue from './components/Home';
import indexVue from './components/Index';
import listVue from './components/List';
import postVue from './components/Post';
import categoriesVue from './components/Categories';
import tagsVue from './components/Tags';
import aboutVue from './components/About';
import _404Vue from './components/NotFound';


export default new VueRouter({
    mode: 'history',
    linkActiveClass: 'current-page',
    routes: [
        {
            path: '/',
            component: homeVue
        },
        {
            path: '/:name(blog)',
            component: indexVue,
            children: [
                {
                    path: '',
                    component: listVue
                },
                {
                    path: 'page/:page',
                    name: 'blog',
                    component: listVue
                },
                {
                    path: ':id',
                    component: postVue
                }
            ]
        },
        {
            path: '/categories',
            component: indexVue,
            children: [
                {
                    path: '',
                    component: categoriesVue
                }
            ]
        },
        {
            path: '/:name(category)/:category',
            component: indexVue,
            children: [
                {
                    path: '',
                    component: listVue
                },
                {
                    path: 'page/:page',
                    name: 'category',
                    component: listVue
                }
            ]
        },
        {
            path: '/tags',
            component: indexVue,
            children: [
                {
                    path: '',
                    component: tagsVue
                }
            ]
        },
        {
            path: '/:name(tag)/:tag',
            component: indexVue,
            children: [
                {
                    path: '',
                    component: listVue
                },
                {
                    path: 'page/:page',
                    name: 'tag',
                    component: listVue
                }
            ]
        },
        {
            path: '/archives',
            component: listVue
        },
        {
            path: '/about',
            component: aboutVue
        },
        {
            path: '*',
            component: _404Vue
        }
    ]
});
// 首页 /
//
// 博文列表 /blog/page/:页码
//
// 博文  /blog/:id
//
// 分类列表 /categories
//
// 分类下的博文列表  /category/:分类名称
//
// 标签列表 /tags
//
// 标签下的博文列表 /tag/:标签名称
//
// 归档 /archives
//
// 关于  /about