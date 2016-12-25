import indexVue from './components/Index';
import listVue from './components/List';
import postVue from './components/Post';
import categoriesVue from './components/Categories';
import tagsVue from './components/Tags';
import aboutVue from './components/About';

module.exports = {
    mode: 'history',
    base: baseRoute, // TODO base 仅用于开发调试，上线时移除
    routes: [
        {
            path: '/',
            component: indexVue
        },
        {
            path: '/blog',
            component: {
                template: '<div><router-view name="nav"></router-view></div>'
            },
            children: [
                {
                    path: '',
                    components: {
                        default: listVue,
                        nav: require('./components/navigation')
                    }
                },
                {
                    path: 'page/:page',
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
            component: categoriesVue
        },
        {
            path: '/category/:category',
            component: listVue
        },
        {
            path: '/tags',
            component: tagsVue
        },
        {
            path: '/tag/:tag',
            component: listVue
        },
        {
            path: '/archives',
            component: listVue
        },
        {
            path: '/about',
            component: aboutVue
        },
    ]
};
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