<template>
    <header class="header-panel" v-once>
        <router-link :to="main_link">
            <img class="logo" :src="logo_url" />
        </router-link>

        <h1 class="header-title">
            <router-link class="header-link" :to="main_link">{{ title }}</router-link>
        </h1>
        <h4 class="header-title">
            {{ subtitle }}
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
                main_link: window.nav.main_link,
                title: window.nav.title,
                subtitle: window.nav.subtitle,
                logo_url: window.nav.logo_url,
                nav: window.nav.nav,
                socially: window.nav.socially
            };
        },
        created () {

        },
        computed: {

        }
    }
</script>
