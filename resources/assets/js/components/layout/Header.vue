<template>
    <header class="header-panel">
        <router-link to="/blog">
            <img class="logo" src="http://ttionya.qiniudn.com/LOGO.gif" />
        </router-link>

        <h1 class="header-title">
            <router-link to="/blog">这是一个 Title</router-link>
        </h1>
        <h2 class="header-title">
            这里是有一点点长的副标题哟~一行不够要两行的哟やだよ
        </h2>

        <nav>
            <ul class="nav-ul">
                <li class="nav-item" v-for="item in nav">
                    <router-link :to="item.path">{{ item.name }}</router-link>
                </li>
            </ul>

            <ul class="nav-ul socially">
                到时候放社交链接，没做
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
                    { path: '/', name: 'Home' },
                    { path: '/blog', name: 'Blog' },
                    { path: '/blog/page/2', name: 'Page 2' },
                    { path: '/blog/3', name: 'Post 3' },
                    { path: '/categories', name: 'Categories' },
                    { path: '/tags', name: 'Tags' },
                    { path: '/archives', name: 'Archives' }
                ];
            }
        }
    }
</script>
