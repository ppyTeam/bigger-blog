<template>
    <div class="pagination">
        <router-link :to="{ name: componentName, params: { page: pageInfo.prev } }" v-if="pageInfo.showPrevBtn">&lt;&lt; Prev</router-link>

        <router-link :to="{ name: componentName, params: { page: 1 } }" v-if="pageInfo.showFirstBtn">1</router-link>

        <span v-if="pageInfo.showPrevDot">...</span>

        <router-link
                :class="{ 'current-page': item.active }"
                :to="{ name: componentName, params: { page: item.page } }"
                v-for="item in pageInfo.pageRange"
                :tag="item.active ? 'span' : 'a'"
        >{{ item.page }}</router-link>

        <span v-if="pageInfo.showNextDot">...</span>

        <router-link :to="{ name: componentName, params: { page: lastPage } }" v-if="pageInfo.showLastBtn">{{ lastPage }}</router-link>

        <router-link :to="{ name: componentName, params: { page: pageInfo.next } }" v-if="pageInfo.showNextBtn">Next &gt;&gt;</router-link>
    </div>
</template>
<style lang="scss">
.pagination {
    text-align: center;

    a,
    span {
        margin: 4px;
        padding: 4px;
    }
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
            pageInfo () {

                /**
                 * << Prev 1 ... 3 4 5 6 7 ... 10 Next >>
                 *
                 **/
                let currentPage = this.currentPage,
                    lastPage = this.lastPage;

                // neighbour page info
                let prevPage = currentPage - 1,
                    nextPage = currentPage + 1,
                    showPrevBtn = true,
                    showNextBtn = true;

                if (prevPage < 1) {
                    prevPage = 1;
                    showPrevBtn = false;
                }
                if (nextPage > lastPage) {
                    nextPage = lastPage;
                    showNextBtn = false;
                }

                // link
                let start = currentPage - 2,
                    stop = currentPage + 2,
                    showFirstBtn = true,
                    showLastBtn = true,
                    showPrevDot = true,
                    showNextDot = true,
                    pageRange = [];

                if (start <= 1) {
                    start = 1;
                    showFirstBtn = showPrevDot = false;
                }
                if (stop >= lastPage) {
                    stop = lastPage;
                    showLastBtn = showNextDot = false;
                }

                // 控制省略号是否显示
                if (start - 1 === 1) {
                    showPrevDot = false;
                }
                if (stop + 1 === lastPage) {
                    showNextDot = false;
                }

                for (; start <= stop; start++) {
                    pageRange.push({
                        page: start,
                        active: start === currentPage
                    });
                }


                return {
                    prev: prevPage,                // 上一页按钮
                    next: nextPage,                // 下一页按钮
                    showPrevBtn: showPrevBtn,      // 显示上一页按钮
                    showNextBtn: showNextBtn,      // 显示下一页按钮
                    pageRange: pageRange,          // 页码范围
                    showFirstBtn: showFirstBtn,    // 显示页码 1 的按钮
                    showLastBtn: showLastBtn,      // 显示页码最后的按钮
                    showPrevDot: showPrevDot,      // 显示前面的省略号
                    showNextDot: showNextDot,      // 显示后面的省略号
                };
            }
        }
    }
</script>
