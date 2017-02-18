<template>
    <div class="header-sidebar-panel" v-once>
        <div class="header-sidebar-overlay"
             :style="{'backgroundImage': 'url(' + bannerUrl + ')' }"
        ></div>
        <router-link :to="navData.main_link">
            <img class="logo" :src="navData.logo_url" />
        </router-link>

        <header class="header-panel">
            <h1 class="header-title">
                <router-link class="header-link" :to="navData.main_link">{{ navData.title }}</router-link>
            </h1>
            <h4 class="header-title">
                {{ navData.subtitle }}
            </h4>

            <div class="header-fast-nav">
                <router-link class="header-fast-nav-item"
                             to="/archives"
                             tag="div"
                >
                    <p>{{ navData.posts_count }}</p>
                    <p>日志</p>
                </router-link>
                <router-link class="header-fast-nav-item header-fast-nav-center"
                             to="/categories"
                             tag="div"
                >
                    <p>{{ navData.categories_count }}</p>
                    <p>分类</p>
                </router-link>
                <router-link class="header-fast-nav-item"
                             to="/tags"
                             tag="div"
                >
                    <p>{{ navData.tags_count }}</p>
                    <p>标签</p>
                </router-link>
            </div>

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
