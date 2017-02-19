<template>
    <div class="header-sidebar-panel" v-once>
        <div class="h-slide-btn">
            <span class="h-slide-span" @click="slideIn">く</span>
        </div>

        <div class="h-overlay"
             :style="{'backgroundImage': 'url(' + bannerUrl + ')' }"
        ></div>
        <router-link :to="navData.main_link">
            <img class="logo" :src="navData.logo_url" :alt="navData.title" />
        </router-link>

        <header class="h-panel">
            <h1 class="h-title">
                <router-link class="h-link" :to="navData.main_link">{{ navData.title }}</router-link>
            </h1>
            <h4 class="h-title">
                {{ navData.subtitle }}
            </h4>

            <div class="h-fast-nav">
                <router-link class="h-fast-nav-item"
                             to="/archives"
                             tag="div"
                >
                    <p>{{ navData.posts_count }}</p>
                    <p>日志</p>
                </router-link>
                <router-link class="h-fast-nav-item h-fast-nav-center"
                             to="/categories"
                             tag="div"
                >
                    <p>{{ navData.categories_count }}</p>
                    <p>分类</p>
                </router-link>
                <router-link class="h-fast-nav-item"
                             to="/tags"
                             tag="div"
                >
                    <p>{{ navData.tags_count }}</p>
                    <p>标签</p>
                </router-link>
            </div>

            <nav class="h-nav">
                <ul class="h-nav-ul">
                    <li class="h-nav-item" v-for="item in navData.nav">
                        <router-link class="h-link" :to="item.url" v-if="item.flag">{{ item.name }}</router-link>
                        <a class="h-link" :href="item.url" target="_blank" v-else>{{ item.name }}</a>
                    </li>
                </ul>
            </nav>

            <nav class="h-socially">
                <ul class="h-nav-ul">
                    <li class="h-socially-item" v-for="item in navData.socially">
                        <a class="h-link" :href="item.url" :title="item.name" target="_blank">
                            <i class="fa fa-lg" :class="'fa-' + item.icon"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </header>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                sidebarOut: true
            }
        },

        methods: {
            slideIn () {
                this.$store.commit('setNavHeaderState', {
                    isOut: false
                })
            }
        },

        computed: {
            navData () {
                return this.$store.state.navData; // 此为浅拷贝，注意不可更改内容
            },
            bannerUrl () {
                return this.navData.banner_url || this.navData.logo_url;
            }
        }
    }
</script>
