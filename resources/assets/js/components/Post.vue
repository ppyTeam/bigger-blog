<template>
    <div class="content-box">
        <div class="content">
            <b-loading v-show="!ready"></b-loading>

            <template v-if="ready">
                <div class="error post" v-if="error.code">
                    <h2>{{ errorMsg }}</h2>
                    <p>Try to <a href="" @click.prevent="fetchList">Reload</a> this page. Or <a href="" @click.prevent="goBack">Go Back</a></p>
                </div>

                <article v-else class="post">

                    <!-- header -->
                    <header class="post-header">
                        <h2 class="post-title">{{ postData.title }}</h2>
                        <span class="post-view-count fa fa-eye" :title="postData.view_count">{{ getFormationViewCount(postData.view_count) }}</span>
                    </header>

                    <!-- content -->
                    <div class="post-content" v-html="postData.content"></div>

                    <!-- footer -->
                    <footer class="post-footer">
                        <span class="post-footer-item fa fa-clock-o"
                              :title="getDateTitle(postData.created_at, postData.updated_at)"
                        >{{ getFormationDate(postData.updated_at || postData.created_at) }}</span><!--

                        --><span class="post-footer-item fa fa-user">{{ postData.user_id }}</span><!--

                        --><span class="post-footer-item fa fa-navicon">
                            <router-link :to="'/category/' + postData.category_name">{{ postData.category_name }}</router-link>
                        </span><!--

                        --><ul class="post-footer-item fa fa-tags" v-if="postData.tags.length">
                            <li class="tag-item" v-for="tag in postData.tags">
                                <router-link :to="'/tag/' + tag.tag_name">{{ tag.tag_name }}</router-link>
                            </li>
                        </ul>
                    </footer>
                </article>

                <aside class="neighbour-box" v-if="hasNeighbour">
                    <router-link class="neighbour-link neighbour-next"
                                 :to="'/blog/' + neighbour.next.id"
                                 v-if="neighbour.next"
                    ><i class="fa fa-chevron-circle-left"></i>{{ neighbour.next.title }}</router-link>

                    <router-link class="neighbour-link neighbour-prev"
                                 :to="'/blog/' + neighbour.prev.id"
                                 v-if="neighbour.prev"
                    >{{ neighbour.prev.title }}<i class="fa fa-chevron-circle-right"></i></router-link>
                </aside>

                <div id="comment" style="height: 300px;"></div>
            </template>
        </div>
    </div>
</template>
<style>
</style>
<script>
    import loadingVue from './layout/Loading';
    import cacheMixin from '../mixins/cache';
    import commonMixin from '../mixins/common';
    import postMixin from '../mixins/post';

    export default {
        components: {
            'b-loading': loadingVue
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
                postData: '',
                hasNeighbour: true
            }
        },


        created () {
            this.fetchPost();
        },


        watch: {
            '$route.path': 'fetchPost'
        },


        methods: {
            fetchPost () {
                this.ready = false;

                // 有缓存的数据
                if (this.cachedData) {
                    this.postData = this.cachedData;

                    this.getReady(); // Ready

                    return;
                }

                // 无缓存的数据
                let path = this.$route.path;
                this.$http.get('/api' + path + (this.blogContent ? '?nocontent=1' : ''))
                    .then(data => {
                        if (this.blogContent) {
                            data.body.main.content = this.blogContent;

                            this.$store.commit('removeBlogContent'); // 从 Vuex 中移除文章正文
                        }

                        this.setError(); // Set Error
                        this.postData = data.body.main;

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

            goBack: () => history.go(-1)
        },


        computed: {
            blogContent () {
                return this.$store.state.blogContent;
            },

            neighbour () {
                let neighbour = this.postData.neighbour,
                    prev, next;

                if (neighbour) {
                    prev = neighbour.prev;
                    next = neighbour.next;

                    this.hasNeighbour = !!prev || !!next || false;
                }
                else {
                    this.hasNeighbour = false;
                }

                return {
                    prev: prev,
                    next: next
                };
            }
        }
    }
</script>
