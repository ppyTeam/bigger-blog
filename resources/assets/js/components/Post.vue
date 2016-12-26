<template>
    <div class="content">
        <p class="error" v-if="error">
            Error: {{ error }}
        </p>
        <article v-else>
            <div class="post-header">
                <h2>标题：{{ title }}</h2>
                <p>更新时间：{{ time }}</p>
                <p>作者：{{ author }}</p>
                <p>分类（取里面的内容报错）：{{ category }}</p>
                <p>标签：{{ tags }}</p>
                <p>上一篇文章：无数据</p>
                <p>下一篇文章：无数据</p>
            </div>

            <div class="post-content" v-html="content"></div>
        </article>
    </div>
</template>
<style>
.error {
    color: red;
}
</style>
<script>
    export default{
        data() {
            return{
                error: '',
                mainData: ''
            }
        },
        mounted: function() {
            this.getPost();
        },
        methods: {
            getPost: function() {
                this.$http.get(baseRoute + '/api' + this.$route.path)
                    .then(data => this.mainData = data.body.main)
                    .catch(error => this.error = error);
            },
        },
        watch: {
            '$route': 'getPost'
        },
        computed: {
            title: function() {
                return this.mainData.title;
            },
            time: function() {
                return this.mainData.updated_at;
            },
            author: function() {
                return this.mainData.user_id;
            },
            category: function() {

                // TODO 再往下取报错
                console.log(this.mainData.category)
                return this.mainData.category;
            },
            tags: function() {
                let tags = [];

                for (let tag in this.mainData.tags) {
                    tags.push(this.mainData.tags[tag].tag_name);
                }

                return tags.join();
            },
            content: function() {
                return this.mainData.content;
            }
        }
    }
</script>
