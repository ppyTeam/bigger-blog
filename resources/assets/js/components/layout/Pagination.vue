<template>
    <div class="pagination" v-if="lastPage >= 1">
        <router-link :to="{ name: componentName, params: { page: 1 } }" v-if="currentPage > 1">&lt;&lt; Prev</router-link>
        <router-link :to="{ name: componentName, params: { page: page } }" v-for="page in pageRange">233</router-link>
        <router-link :to="{ name: componentName, params: { page: lastPage } }" v-if="currentPage < lastPage">Next &gt;&gt;</router-link>
    </div>
</template>
<style lang="scss">
.pagination {
    text-align: center;
}
</style>
<script>
    export default {
        data () {
            return {

            };
        },

        props: [
            'currentPage',
            'lastPage'
        ],

        methods: {

        },

        computed: {
            // TODO 不知是否能监听到 $route 的变化，待测试
            componentName () {
                return this.$route.params.name;
            },
            pageRange () {
                let currentPage = this.currentPage,
                    lastPage = this.lastPage,
                    start = currentPage - 2,
                    stop = currentPage + 2,
                    array = [];

                start = start < 1 ? 1 : start;
                stop = stop > lastPage ? lastPage : stop;

                for (; start <= stop; start++) {
                    array.push(start);
                }

                return array;
            }
        }
    }
</script>
