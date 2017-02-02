<template>
    <div class="content-box">
        <div class="content">
            <b-loading v-show="!ready"></b-loading>

            <template v-if="ready">
                <b-error :error="error"
                         @reload="fetchList"
                         v-if="error.code !== undefined"
                ></b-error>

                <template v-else>
                    <!-- Empty post list -->
                    <div class="post" v-if="emptyList">
                        <h2>没有任何内容哦~</h2><!-- TODO 做一个图片吧，待定 -->
                    </div>

                    <!-- NOT empty post list -->
                    <template v-else v-for="post in mainData.data">
                        <article class="post">

                            <!-- header -->
                            <header class="post-header">
                                <h2 class="post-title"><router-link :to="'/blog/' + post.id">{{ post.title }}</router-link></h2>
                                <span class="post-header-span fa fa-clock-o"
                                      :title="getDateTitle(post.created_at, post.updated_at)"
                                >{{ getFormationDate(post.updated_at || post.created_at) }}</span>
                                <!--<span class="post-view-count fa fa-eye" :title="post.view_count">{{ getFormationViewCount(post.view_count) }}</span>-->
                            </header>

                            <!-- content -->
                            <div class="post-content" v-html="post.content"></div>

                            <!-- more link -->
                            <p class="post-more" v-if="post.more_link">
                                <router-link class="post-more-link" :to="'/blog/' + post.id">More >></router-link>
                            </p>

                            <!-- footer -->
                            <footer class="post-footer">
                                <span class="post-footer-item fa fa-user">{{ post.user_id }}</span><!--

                                --><span class="post-footer-item fa fa-navicon">
                                    <router-link :to="'/category/' + post.category_name">{{ post.category_name }}</router-link>
                                </span><!--

                                --><ul class="post-footer-item fa fa-tags" v-if="post.tags.length">
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
    import errorVue from './layout/Error';
    import pageVue from './layout/Pagination';
    import cacheMixin from '../mixins/cache';
    import commonMixin from '../mixins/common';
    import postMixin from '../mixins/post';

    export default {
        components: {
            'b-loading': loadingVue,
            'b-error': errorVue,
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
            '$route.path' (to, from) {
                if (from + '/page/1' === to) return;
                if (to + '/page/1' === from) return;

                this.fetchList();
            }
        },


        methods: {
            fetchList () {
                this.ready = false;
                this.setError(); // Set Error

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
                        this.mainData = data.body.main;

                        this.$store.commit('setCachedData', {
                            path: this.getCachedListPath(this.$route),
                            data: data.body.main
                        });

                        this.getReady(); // Ready
                    })
                    .catch(error => {
                        this.setError(error);

                        this.getReady(); // Ready
                    });
            }
        },

        computed: {
            emptyList () {
                return !(this.mainData.data.length);
            }
        }
    }
</script>
