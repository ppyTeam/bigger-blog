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
                        <span class="post-view-count fa fa-eye">{{ postData.view_count + 8888 + ' 万' }}</span>
                    </header>

                    <!-- content -->
                    <div class="post-content" v-html="postData.content"></div>

                    <!-- footer -->
                    <footer class="post-footer">
                    <span class="post-footer-item fa fa-clock-o" :title="dateTitle">
                        {{ getDate(updated_at || created_at) }}
                    </span>
                        <span class="post-footer-item fa fa-user">
                        {{ postData.user_id }}
                    </span>
                        <!-- // TODO 移除否？ <router-link class="post-footer-item" :to="'/category/' + postData.category_name">{{ postData.category_name }}</router-link>-->
                        <ul class="post-footer-item fa fa-tags" v-if="postData.tags && postData.tags.length">
                            <li class="tag-item" v-for="tag in postData.tags">
                                <router-link :to="'/tag/' + tag.tag_name">{{ tag.tag_name }}</router-link>
                            </li>
                        </ul>
                    </footer>
                </article>
                <aside v-if="showNeighbour">
                    <p v-if="neighbour.prev">上一篇：<router-link :to="'/blog/' + neighbour.prev.id">{{ neighbour.prev.title }}</router-link></p>
                    <p v-if="neighbour.next">下一篇：<router-link :to="'/blog/' + neighbour.next.id">{{ neighbour.next.title }}</router-link></p>
                </aside>

            </template>
        </div>
    </div>
</template>
<style>
</style>
<script>
    import loadingVue from './layout/Loading';


    export default {
        components: {
            'b-loading': loadingVue
        },


        data () {
            return {
                ready: false,
                error: { },
                postData: '',
                showNeighbour: true
            }
        },


        created () {
            this.fetchPost();
        },


        watch: {
            '$route': 'fetchPost'
        },


        methods: {
            fetchPost () {
                let self = this;

                // 有缓存的数据
                if (self.cachedData) {
                    self.postData = self.cachedData;

                    setTimeout(() => self.ready = true, 200);

                    return;
                }

                // 无缓存的数据
                self.$http.get('/api' + self.$route.path + (self.blogContent ? '?nocontent=1' : ''))
                    .then(data => {
                        if (self.blogContent) {
                            data.body.main.content = self.blogContent;

                            self.$store.commit('removeBlogContent'); // 从 Vuex 中移除文章正文
                        }

                        self.error = { };
                        self.postData = data.body.main;

                        setTimeout(() => self.ready = true, 200);

                        self.$store.commit('setCachedData', {
                            path: self.$route.path,
                            data: data.body.main
                        });
                    })
                    .catch(error => {
                        self.error = {
                            code: error.status,
                            Text: error.statusText
                        };
                    });
            },
            getDate (date) { // TODO 待移走
                let mm, dd;

                date = new Date(date);
                mm = ('0' + (date.getMonth() + 1)).slice(-2);
                dd = ('0' + date.getDate()).slice(-2);

                return date.getFullYear() + '-' + mm + '-' + dd;
            },
            goBack: () => history.go(-1)
        },


        computed: {
            cachedData () {
                let self = this,
                    path = self.$route.path,
                    cachedData = self.$store.state.data[path];

                if (!cachedData) return null;

                // 暂定 60s = 60000ms
                if (cachedData.timestamp <= Date.now() - 60000) {
                    self.$store.commit('removeCachedData', path); // 移除

                    return null;
                }

                return cachedData.data;
            },
            blogContent () {
                return this.$store.state.blogContent;
            },

            updated_at () {
                return this.postData.updated_at;
            },
            created_at () {
                return this.postData.created_at;
            },
            dateTitle () {
                let self = this;

                if (self.updated_at) {
                    return 'Updated at ' + self.updated_at + '\nCreated at ' + self.created_at;
                }
                else {
                    return 'Created at ' + self.created_at;
                }
            },
            // TODO 有 bug ，加上 loading 即可
            neighbour () {
                let self = this,
                    neighbour = self.postData.neighbour,
                    prev, next;

                if (neighbour) {
                    prev = neighbour.prev;
                    next = neighbour.next;

                    self.showNeighbour = !!prev || !!next || false;
                }
                else {
                    self.showNeighbour = false;
                }

                return {
                    prev: prev,
                    next: next
                };
            }
        }
    }
</script>
