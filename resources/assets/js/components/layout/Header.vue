<template>
    <div class="header-sidebar-panel" v-once>
        <!-- 收缩按钮 -->
        <div class="h-in-btn">
            <span class="h-in-span" @click="slide(false)">く</span>
        </div>

        <!-- 展开按钮 -->
        <i class="h-out-btn fa fa-sign-out fa-lg" @click="slide(true)"></i>

        <!-- 头像背景 -->
        <div class="h-overlay"
             :style="{'backgroundImage': 'url(' + bannerUrl + ')' }"
        ></div>
        <router-link :to="navData.main_link">
            <img class="logo" :src="navData.logo_url" :title="navData.title" />
        </router-link>

        <header class="h-panel">
            <h1 class="h-title">
                <router-link class="h-link" :to="navData.main_link">{{ navData.title }}</router-link>
            </h1>
            <h4 class="h-title">
                {{ navData.subtitle }}
            </h4>

            <nav class="h-fast-nav">
                <router-link class="h-fast-nav-item"
                             to="/archives"
                             tag="div"
                >
                    <i class="fa fa-map-signs fa-lg"></i>
                    <p class="h-fast-nav-num">{{ navData.posts_count }}</p>
                    <p>归档</p>
                </router-link>
                <router-link class="h-fast-nav-item"
                             to="/categories"
                             tag="div"
                >
                    <i class="fa fa-list fa-lg"></i>
                    <p class="h-fast-nav-num">{{ navData.categories_count }}</p>
                    <p>分类</p>
                </router-link>
                <router-link class="h-fast-nav-item"
                             to="/tags"
                             tag="div"
                >
                    <i class="fa fa-tags fa-lg"></i>
                    <p class="h-fast-nav-num">{{ navData.tags_count }}</p>
                    <p>标签</p>
                </router-link>
            </nav>

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
            slide (state) {
                this.$store.commit('setNavHeaderState', {
                    isOut: state
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
