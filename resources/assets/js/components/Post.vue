<template>
    <div class="content-box">
        <div class="content">
            <!-- TODO Something wrong 移至 loading -->
            <div class="error post" v-if="error.code">
                <h2>{{ errorMsg }}</h2>
                <p>Try to <a href="" @click.prevent="fetchList">Reload</a> this page. Or <a href="" @click.prevent="goBack">Go Back</a></p>
            </div>

            <div v-if="showLoading">
                <a-loading class="card-content"></a-loading>
            </div>

            <article v-else class="post">

                <!-- header -->
                <header class="post-header">
                    <h2 class="post-title">{{ post.title }}</h2>
                    <span class="post-view-count fa fa-eye">{{ post.view_count }}</span><!-- TODO 是否移除 -->
                </header>

                <!-- content -->
                <div class="post-content" v-html="post.content"></div>

                <!-- footer -->
                <footer class="post-footer">
                    <span class="post-footer-item fa fa-clock-o" :title="dateTitle">
                        {{ getDate(updated_at || created_at) }}
                    </span>
                    <span class="post-footer-item fa fa-user">
                        {{ post.user_id }}
                    </span>
                    <!-- // TODO 移除否？ <router-link class="post-footer-item" :to="'/category/' + post.category_name">{{ post.category_name }}</router-link>-->
                    <ul class="post-footer-item fa fa-tags" v-if="post.tags && post.tags.length">
                        <li class="tag-item" v-for="tag in post.tags">
                            <router-link :to="'/tag/' + tag.tag_name">{{ tag.tag_name }}</router-link>
                        </li>
                    </ul>
                </footer>
            </article>
            <aside v-if="showNeighbour">
                <p v-if="neighbour.prev">上一篇：<router-link :to="'/blog/' + neighbour.prev.id">{{ neighbour.prev.title }}</router-link></p>
                <p v-if="neighbour.next">下一篇：<router-link :to="'/blog/' + neighbour.next.id">{{ neighbour.next.title }}</router-link></p>
            </aside>
        </div>
    </div>
</template>
<style>
</style>
<script>
    import loading from './layout/Loading';
    export default {
    components:{
            'a-loading': loading,
        },
        data() {
            return {
                showLoading: true,
                error: { },
                post: '',
                showNeighbour: true
            }
        },

        mounted: function() {
            this.fetchPost();
        },
        watch: {
            '$route': 'fetchPost'
        },
        methods: {
            fetchPost: function() {
                let self = this;

                self.showLoading = true;

                self.$http.get('/api' + self.$route.path)
                    .then(data => {
                        self.error = { };
                        self.post = data.body.main;
                        self.showLoading = false;
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
            updated_at () {
                return this.post.updated_at;
            },
            created_at () {
                return this.post.created_at;
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
                    neighbour = self.post.neighbour,
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
