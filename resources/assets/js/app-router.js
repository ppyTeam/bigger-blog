import indexVue from './components/index';
import listVue from './components/list';
import postVue from './components/post';

module.exports = {
    mode: 'history',
    base: '/bigger-blog/public/',
    routes: [
        {
            path:'/',
            component: indexVue,
            children: [
                {
                    path: 'blog',
                    component: listVue
                },
                {
                    path: 'blog/:id',
                    component: postVue
                }
            ]
        }
    ]
};