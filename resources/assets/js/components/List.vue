<template>
    <div class="content-box">
        <div class="content">
            <div class="error post" v-if="error.code">
                <h2>{{ errorMsg }}</h2>
                <p>Try to <a href="" @click.prevent="fetchList">Reload</a> this page. Or <a href="" @click.prevent="goBack">Go Back</a></p>
            </div>
            <!-- TODO 判断无文章 -->
            <template v-else v-for="post in mainData.data">
                <article class="post">
                    <header class="post-header">
                        <h2><router-link :to="'/blog/' + post.id">{{ post.title }}</router-link></h2>
                    </header>
                    <div class="post-content">
                        {{ post.content }}
                        <p class="post-more" v-if="more">
                            <router-link class="post-more-link" :to="'/blog/' + post.id">More >></router-link>
                        </p>
                        <hr>
                    </div>
                    <footer class="post-footer">
                        <p>
                            <span>Posted by {{ post.user_id }}</span>
                            &nbsp;<span v-html="getDate(post.created_at, post.updated_at)"></span>
                        </p>
                        <p>
                            <router-link :to="'/category/' + post.category_name">{{ post.category_name }}</router-link>
                        </p>
                        <template v-for="tag in post.tags">
                            <router-link :to="'/tag/' + tag.tag_name">
                                {{ tag.tag_name }}
                            </router-link>
                        </template>
                    </footer>
                </article>
            </template>
        </div>
    </div>
</template>
<style lang="scss">
header {
    margin: 0;
    padding: 0;
}

.content-box {
    position: absolute;
    right: 0;
    left: 300px;

    .content {
        max-width: 1040px;
        margin: 0 auto;
    }

    .post {
        margin: 40px;
        padding: 40px 60px;

        border: 1px solid #ddd;
        background-color: #fff;

        h2 {
            line-height: 3rem;
        }

        .post-content {
            line-height: 1.8rem
        }

        .post-more {
            margin-top: 10px;

            .post-more-link {
                padding: 2px 8px 4px;
                color: #fff;
                line-height: 1.6rem;
                font-size: 1.2rem;
                text-decoration: none;
                border-radius: 2px;
                background-color: #4d4d4d;
            }
        }
    }

    .error {
        h2 {
            color: red;
        }
    }
}
</style>
<script>
    export default {
        data() {
            return {
                error: { },
                mainData: '',
                more: true
            }
        },

        mounted () {
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
                    })
                    .catch(error => {
                        self.error = {
                            code: error.status,
                            text: error.statusText
                        }
                    });
            },
            getDate (created_at, updated_at) {
                if (updated_at) {
                    return '<span title="Created at ' + created_at + '">Updated at ' + updated_at + '</span>';
                }
                else {
                    return '<span>Created at ' + created_at + '</span>';
                }
            },
            goBack: () => history.go(-1)
        },

        computed: {
            errorMsg () {
                let self = this;

                return self.error.code + ' ' + self.error.text;
            }
        }
    }
</script>
