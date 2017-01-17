<template>
    <div class="content-box">
        <div class="content">
            <b-loading v-show="!ready"></b-loading>

            <template v-if="ready">
                <div class="error post" v-if="error.code">
                    <h2>{{ errorMsg }}</h2>
                    <p>Try to <a href="" @click.prevent="fetchList">Reload</a> this page. Or <a href="" @click.prevent="goBack">Go Back</a></p>
                </div>

                <template v-else>
                    <!-- Empty post list -->
                    <div class="post" v-if="emptyList">
                        <h2>没有任何内容哦~</h2>
                        <p>Try to <a href="" @click.prevent="fetchList">Reload</a> this page. Or <a href="" @click.prevent="goBack">Go Back</a></p>
                    </div>

                    <!-- NOT empty post list -->
                    <template v-else v-for="post in mainData.data">
                        <article class="post">

                            <!-- header -->
                            <header class="post-header">
                                <h2 class="post-title"><router-link :to="'/blog/' + post.id">{{ post.title }}</router-link></h2>
                                <span class="post-view-count fa fa-eye" :title="post.view_count">{{ getFormationViewCount(post.view_count) }}</span>
                            </header>

                            <!-- content -->
                            <div class="post-content" v-html="post.content"></div>

                            <!-- more link -->
                            <p class="post-more" v-if="post.more_link">
                                <router-link class="post-more-link" :to="'/blog/' + post.id">More >></router-link>
                            </p>

                            <!-- footer -->
                            <footer class="post-footer">
                            <span class="post-footer-item fa fa-clock-o" :title="getDateTitle(post.created_at, post.updated_at)">
                                {{ getFormationDate(post.updated_at || post.created_at) }}
                            </span>
                                <span class="post-footer-item fa fa-user">
                                {{ post.user_id }}
                            </span>
                                <!-- // TODO 移除否？ <router-link class="post-footer-item" :to="'/category/' + post.category_name">{{ post.category_name }}</router-link>-->
                                <ul class="post-footer-item fa fa-tags" v-if="post.tags.length">
                                    <li class="tag-item" v-for="tag in post.tags">
                                        <router-link :to="'/tag/' + tag.tag_name">{{ tag.tag_name }}</router-link>
                                    </li>
                                </ul>
                            </footer>
                        </article>
                    </template>

                    <b-pagination
                            :current-page="mainData.current_page"
                            :last-page="mainData.last_page"
                    ></b-pagination>
                </template>
            </template>


        </div>
    </div>
</template>
<script>
    import loadingVue from './layout/Loading';
    import pageVue from './layout/Pagination';
    import cacheMixin from '../mixins/cache';
    import commonMixin from '../mixins/common';
    import postMixin from '../mixins/post';

    export default {
        components: {
            'b-loading': loadingVue,
            'b-pagination': pageVue
        },


        mixins: [
            cacheMixin,
            commonMixin,
            postMixin
        ],


        data () {
            return {
                ready: false,
                error: { },
                mainData: ''
            };
        },


        created () {
            this.fetchList();
        },


        watch: {
            '$route': 'fetchList'
        },


        methods: {
            fetchList () {
                this.ready = false;

                // 有缓存的数据
                if (this.cachedData) {
                    this.mainData = this.cachedData;

                    this.getReady(); // Ready

                    return;
                }

                // 无缓存的数据
                let path = this.$route.path;
                this.$http.get('/api' + path)
                    .then(data => {
                        this.setError(); // Set Error
                        this.mainData = data.body.main;

                        this.$store.commit('setCachedData', {
                            path: path,
                            data: data.body.main
                        });

                        this.getReady(); // Ready
                    })
                    .catch(error => {
                        this.setError(error);

                        this.getReady(); // Ready
                    });
            },
            goBack: () => history.go(-1) // TODO 待移走
        },

        computed: {
            errorMsg () {
                let self = this;

                return self.error.code ?
                    self.error.code + ' ' + self.error.text :
                    '';
            },
            emptyList () {
                return !(this.mainData.data && this.mainData.data.length);
            }
        }
    }
</script>
