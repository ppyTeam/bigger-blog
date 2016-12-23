import indexVue from './components/index';
import postVue from './components/post';

module.exports = {
    mode: 'history',
    base: '/bigger-blog/public/',
    routes: [
        {
            path:'/',
            component: indexVue
        },
        {
            path: '/blog',
            component: indexVue,
        },
        {
            path: '/blog/:id',
            component: indexVue,
            children: [
                {
                    path: '',
                    component: postVue
                }
            ]
        }

    ]
};