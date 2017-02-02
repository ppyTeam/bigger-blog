<template>
    <div class="pagination">
        <ul class="p-ul">
            <li class="p-li" v-show="pageInfo.showPrevBtn">
                <router-link
                        class="p-link p-near"
                        :to="{ name: componentName, params: { page: pageInfo.prev } }"
                >Prev</router-link>
            </li>

            <li class="p-li" v-show="pageInfo.showFirstBtn">
                <router-link
                        class="p-link p-a"
                        :to="{ name: componentName, params: { page: 1 } }"
                >1</router-link>
            </li>

            <li class="p-li" v-show="pageInfo.showPrevDot">
                <router-link
                        class="p-link p-dot fa"
                        :to="{ name: componentName, params: { page: 1 } }"
                ></router-link>
            </li>

            <li class="p-li" v-for="item in pageInfo.pageRange">
                <router-link
                        class="p-link p-a"
                        :class="{ 'current-page': item.active }"
                        :to="{ name: componentName, params: { page: item.page } }"
                        :tag="item.active ? 'span' : 'a'"
                >{{ item.page }}</router-link>
            </li>

            <li class="p-li" v-show="pageInfo.showNextDot">
                <router-link
                        class="p-link p-dot fa"
                        :to="{ name: componentName, params: { page: 1 } }"
                ></router-link>
            </li>

            <li class="p-li" v-show="pageInfo.showLastBtn">
                <router-link
                        class="p-link p-a"
                        :to="{ name: componentName, params: { page: lastPage } }"
                >{{ lastPage }}</router-link>
            </li>

            <li class="p-li" v-show="pageInfo.showNextBtn">
                <router-link
                        class="p-link p-near"
                        :to="{ name: componentName, params: { page: pageInfo.next } }"
                >Next</router-link>
            </li>
        </ul>
    </div>
</template>
<style lang="scss">
.pagination {
    .p-dot {
        &::before {
            content: '...';
        }

        &:hover::before {
            content: '\f100';
        }
    }

    .current-page {
        color: #607c5d;
        background-color: #d0dfcf;
    }

    .p-link {
        display: inline-block;
        margin-right: 6px;
        padding: 9px 12px;
        color: #a2c49e;
        border-radius: 16px;
        background-color: #363842;
        transition: all 0.3s linear;

        &:hover {
            color: #fff;
        }
    }

    .p-near {
        padding: 9px 13px;
        color: #fff;
        background-color: #607c5d;

        &:hover {
            background-color: #486f43;
        }
    }
}
</style>
<script>
    export default {
        props: [
            'currentPage',
            'lastPage'
        ],


        computed: {
            componentName () {
                return this.$route.params.name;
            },


            pageInfo () {

                /**
                 * Prev ① ... ④ ⑤ ⑥ ... ⑩ Next
                 * https://designshack.net/tutorialexamples/css3-pagination/index-4.html
                 *
                 **/
                let currentPage = this.currentPage,
                    lastPage = this.lastPage;

                // neighbour page info
                let prevPage = currentPage - 1,
                    nextPage = currentPage + 1,
                    showPrevBtn = true,
                    showNextBtn = true;


                if (prevPage < 1) { // 当前页为第一页
                    prevPage = 1;
                    showPrevBtn = false;
                }
                if (nextPage > lastPage) { // 当前页为最后一页
                    nextPage = lastPage;
                    showNextBtn = false;
                }

                // link
                let start = currentPage - 1,
                    stop = currentPage + 1,
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
                    prev: prevPage, // 上一页按钮
                    next: nextPage, // 下一页按钮
                    showPrevBtn,    // 显示上一页按钮
                    showNextBtn,    // 显示下一页按钮
                    pageRange,      // 页码范围
                    showFirstBtn,   // 显示页码 1 的按钮
                    showLastBtn,    // 显示页码最后的按钮
                    showPrevDot,    // 显示前面的省略号
                    showNextDot     // 显示后面的省略号
                };
            }
        }
    }
</script>
