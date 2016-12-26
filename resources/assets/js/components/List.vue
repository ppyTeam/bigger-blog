<template>
    <div class="content">
        <p class="error" v-if="error">
            Error: {{ error }}
        </p>
        <template v-else v-for="item in mainData.data">
            <article>
                {{ item.category.category_name }} > <router-link :to="'/blog/' + item.id"><h2>{{ item.title }}</h2></router-link>
                <p>{{ item.updated_at }} Posted by {{ item.user_id }}</p>
                <div>
                    {{ item.content }}
                </div>
            </article>
            <hr>
        </template>
    </div>
</template>
<style lang="scss">
article {
    h2 {
        display: inline;
        word-break: break-all;
        word-wrap: break-word;
    }

    p {
        margin: 0;
    }
}
</style>
<script>
    export default {
        data() {
            return {
                error: '',
                mainData: ''
            }
        },
        mounted: function() {
            this.getList();
        },
        methods: {
            getList: function() {
                this.$http.get(baseRoute + '/api' + this.$route.path)
                    .then(data => this.mainData = data.body.main)
                    .catch(error => this.error = error);
            },
        },
        computed: {

        },
        components:{

        }
    }
</script>
