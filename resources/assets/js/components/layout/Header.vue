<template>
    <header class="header-panel" v-once>
        <router-link :to="navData.main_link">
            <img class="logo" :src="navData.logo_url" />
        </router-link>

        <h1 class="header-title">
            <router-link class="header-link" :to="navData.main_link">{{ navData.title }}</router-link>
        </h1>
        <h4 class="header-title">
            {{ navData.subtitle }}
        </h4>

        <hr>

        <nav class="header-nav">
            <ul class="nav-ul">
                <li class="nav-item" v-for="item in navData.nav">
                    <router-link class="header-link" :to="item.url" v-if="item.flag">{{ item.name }}</router-link>
                    <a class="header-link" :href="item.url" target="_blank" v-else>{{ item.name }}</a>
                </li>
            </ul>
        </nav>

        <nav class="header-socially">
            <ul class="nav-ul">
                <li class="socially-item" v-for="item in navData.socially">
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
        computed: {
            navData () {
                return this.$store.state.navData; // 此为浅拷贝，注意不可更改内容
            }
        }
    }
</script>
