<template>
    <div class="content-box">
        <div class="content">
            <div class="error post" v-if="error.code">
                <h2>Error: {{ error.Text }}</h2>
                <p>Try to <a href="" @click.prevent="fetchPost">Reload</a> this page. Or <a href="" @click.prevent="goBack">Go Back</a></p>
            </div>
            <article v-else class="post">
                <header class="post-header">
                    <h2>{{ mainData.title }}</h2>
                </header>
                <div class="post-content" v-html="mainData.content"></div>
                <hr>
                <footer class="post-footer">
                    <span>{{ mainData.updated_at }} Posted by {{ mainData.user_id }}</span>
                    <br>
                    <span>{{ mainData.category && mainData.category.category_name }}</span>
                    <br>
                    <template v-for="tag in mainData.tags">
                        <router-link :to="'/tag/' + tag.tag_name">
                            {{ tag.tag_name }}
                        </router-link>
                    </template>
                </footer>
            </article>
            <aside v-if="mainData.neighbour">
                <p v-if="mainData.neighbour.prev">上一篇：<router-link :to="'/blog/' + mainData.neighbour.prev.id">{{ mainData.neighbour.prev.title }}</router-link></p>
                <p v-if="mainData.neighbour.next">下一篇：<router-link :to="'/blog/' + mainData.neighbour.next.id">{{ mainData.neighbour.next.title }}</router-link></p>
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
                mainData: []
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
                        self.mainData = data.body.main;
                    })
                    .catch(error => {
                        self.error = {
                            code: error.status,
                            Text: error.statusText
                        }
                    });
            },
            goBack: () => history.go(-1)
        },
        computed: {

        }
    }
</script>
