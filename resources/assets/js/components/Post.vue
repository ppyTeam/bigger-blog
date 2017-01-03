<template>
    <div class="content-box">
        <div class="content">
            <div class="error post" v-if="error.code">
                <h2>Error: {{ error.Text }}</h2>
                <p>Try to <a href="" @click.prevent="fetchPost">Reload</a> this page. Or <a href="" @click.prevent="goBack">Go Back</a></p>
            </div>
            <article v-else class="post">
                <header class="post-header">
                    <h2>{{ post.title }}</h2>
                </header>
                <div class="post-content" v-html="post.content"></div>
                <hr>
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
            <aside v-if="post.neighbour">
                <p v-if="post.neighbour.prev">上一篇：<router-link :to="'/blog/' + post.neighbour.prev.id">{{ post.neighbour.prev.title }}</router-link></p>
                <p v-if="post.neighbour.next">下一篇：<router-link :to="'/blog/' + post.neighbour.next.id">{{ post.neighbour.next.title }}</router-link></p>
            </aside>
        </div>
    </div>
</template>
<style>
</style>
<script>
    export default{
        data() {
            return{
                error: { },
                post: ''
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

                self.$http.get('/api' + self.$route.path)
                    .then(data => {
                        self.error = { };
                        self.post = data.body.main;
                    })
                    .catch(error => {
                        self.error = {
                            code: error.status,
                            Text: error.statusText
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

        }
    }
</script>
