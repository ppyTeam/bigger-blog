<template>
    <div class="pagination">
        <ul class="pag-ul">
            <li class="pag-li" v-show="pageInfo.showPrevBtn">
                <router-link
                        class="pag-item"
                        :to="{ name: componentName, params: { page: pageInfo.prev } }"
                >Prev</router-link>
            </li>

            <li class="pag-li" v-show="pageInfo.showFirstBtn">
                <router-link
                        class="pag-item"
                        :to="{ name: componentName, params: { page: 1 } }"
                >1</router-link>
            </li>

            <li class="pag-li" v-show="pageInfo.showPrevDot">
                <router-link
                        class="pag-item pag-dot fa"
                        :to="{ name: componentName, params: { page: pageInfo.fastPrev } }"
                ></router-link>
            </li>

            <li class="pag-li" v-for="item in pageInfo.pageRange">
                <span
                        class="pag-item current-page"
                        v-if="item.active"
                >{{ item.page }}</span>
                <router-link
                        class="pag-item"
                        :to="{ name: componentName, params: { page: item.page } }"
                        v-else
                >{{ item.page }}</router-link>
            </li>

            <li class="pag-li" v-show="pageInfo.showNextDot">
                <router-link
                        class="pag-item pag-dot pag-dot-r fa"
                        :to="{ name: componentName, params: { page: pageInfo.fastNext } }"
                ></router-link>
            </li>

            <li class="pag-li" v-show="pageInfo.showLastBtn">
                <router-link
                        class="pag-item"
                        :to="{ name: componentName, params: { page: lastPage } }"
                >{{ lastPage }}</router-link>
            </li>

            <li class="pag-li" v-show="pageInfo.showNextBtn">
                <router-link
                        class="pag-item"
                        :to="{ name: componentName, params: { page: pageInfo.next } }"
                >Next</router-link>
            </li>
        </ul>
    </div>
</template>

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
                 * https://designshack.net/tutorialexamples/css3-pagination/index-2.html
                 *
                 **/
                let currentPage = this.currentPage,
                    lastPage = this.lastPage;

                // neighbour page info
                let prevPage = currentPage - 1, // 上一页
                    nextPage = currentPage + 1, // 下一页
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
                    fastPrevPage = currentPage - 5,
                    fastNextPage = currentPage + 5,
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

                // 快速翻页
                fastPrevPage = fastPrevPage < 1 ? 1 : fastPrevPage;
                fastNextPage = fastNextPage > lastPage ? lastPage : fastNextPage;

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
                    showNextDot,    // 显示后面的省略号
                    fastPrev: fastPrevPage, // 快速上翻
                    fastNext: fastNextPage  // 快速下翻
                };
            }
        }
    }
</script>
