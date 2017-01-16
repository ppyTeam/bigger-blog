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
                                <span class="post-view-count fa fa-eye">{{ post.view_count + 8888 + ' 万' }}</span>
                            </header>

                            <!-- content -->
                            <div class="post-content" v-html="post.content"></div>

                            <!-- more link -->
                            <p class="post-more" v-if="post.more_link">
                                <router-link class="post-more-link" :to="'/blog/' + post.id">More >></router-link>
                            </p>

                            <!-- footer -->
                            <footer class="post-footer">
                            <span class="post-footer-item fa fa-clock-o" :title="getDateTitle(post.updated_at, post.created_at)">
                                {{ getDate(post.updated_at || post.created_at) }}
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

    export default {
        components: {
            'b-loading': loadingVue,
            'b-pagination': pageVue
        },

        data () {
            return {
                ready: false,
                error: { },
                mainData: ''
            };
        },

        //beforeRouteEnter (to, from, next) {

        //    next(vm => {
        //        vm.$store.commit('x', false);
        //    });
        //},
        //beforeRouteLeave (to, from, next) {
        //    this.$store.commit('x', true);
        //    next()
        //},
        created () {
            this.fetchList();
        },

        watch: {
            '$route': 'fetchList'
        },

        methods: {
            fetchList () {
                let self = this;

                self.$http.get('/api' + self.$route.path)
                    .then(data => {
                        self.error = { };
                        self.mainData = data.body.main;
setTimeout(() => self.ready = true, 200);
                    })
                    .catch(error => {
                        self.error = {
                            code: error.status,
                            text: error.statusText
                        };

                    });
            },
            getDateTitle (created_at, updated_at) {
                if (updated_at) {
                    return 'Updated at ' + updated_at + '\nCreated at ' + created_at;
                }
                else {
                    return 'Created at ' + created_at;
                }
            },
            getDate (date) { // TODO 待移走
                let mm, dd;

                date = new Date(date);
                mm = ('0' + (date.getMonth() + 1)).slice(-2);
                dd = ('0' + date.getDate()).slice(-2);

                return date.getFullYear() + '-' + mm + '-' + dd;
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
