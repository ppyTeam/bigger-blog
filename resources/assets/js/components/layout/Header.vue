<template>
    <header class="header-panel">
        <router-link to="/blog">
            <img class="logo" src="http://ttionya.qiniudn.com/LOGO.gif" />
        </router-link>

        <h1 class="header-title">
            <router-link class="header-link" to="/blog">我要搞一个大标题</router-link>
        </h1>
        <h4 class="header-title">
            副标题的最佳体验是十五个中国字
            多了要换行，最好少于15个字
        </h4>

        <hr>

        <nav class="header-nav">
            <ul class="nav-ul">
                <li class="nav-item" v-for="item in nav">
                    <router-link class="header-link" :to="item.url" v-if="item.flag">{{ item.name }}</router-link>
                    <a class="header-link" :href="item.url" target="_blank" v-else>{{ item.name }}</a>
                </li>
            </ul>
        </nav>

        <nav class="header-socially">
            <ul class="nav-ul">
                <li class="socially-item" v-for="item in socially">
                    <a class="header-link" :href="item.url" :title="item.name" target="_blank">
                        <i class="fa fa-lg" :class="'fa-' + item.type"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
</template>
<script>
    export default {
        data () {
            return {

            };
        },
        created () {

        },
        computed: {
            nav () {
                return [
                    { url: '/', name: 'Home', flag: true },
                    { url: '/blog', name: 'Blog', flag: true },
                    //{ url: '/blog/page/2', name: 'Page 2', flag: true },
                    //{ url: '/blog/3', name: 'Post 3', flag: true },
                    //{ url: '/categories', name: 'Categories', flag: true },
                    //{ url: '/tags', name: 'Tags', flag: true },
                    { url: '/archives', name: 'Archives', flag: true },
                    { url: 'https://github.com/ppyTeam/bigger-blog/tree/dev', name: 'Github', flag: false }
                ];
            },
            socially () {
                return [
                    { url: 'https://github.com/ppyTeam/bigger-blog/tree/dev', name: 'Github', type: 'github' },
                    { url: 'http://weibo.com/', name: 'Weibo', type: 'weibo' },
                    { url: 'http://steamcommunity.com/id/ttionya/', name: 'Steam', type: 'steam' }
                ];
            }
        }
    }
</script>
