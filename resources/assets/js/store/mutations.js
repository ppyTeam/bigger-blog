// 获得文章内页的正文内容，请求数据时不再发送正文内容
export const initBlogContent = state => {
    const d = document,
        htmlSEOContainer = d.getElementById('html-seo-container'),
        contentEle = htmlSEOContainer.querySelector('#content');

    state.blogContent = contentEle && contentEle.innerHTML || '';

    htmlSEOContainer.parentNode.removeChild(htmlSEOContainer);
};

// 移除文章内页的正文内容，减少内存占用
export const removeBlogContent = state => state.blogContent = '';



// 初始化导航数据
export const initNavData = state => {
    state.navData = window.navData;
    delete window.navData;
};



// 保存数据到 Vuex 中，一段时间内读缓存的内容，否则重新请求
export const setCachedData = (state, { path, data }) => {

    // 没有获得路径，则返回
    if (!path) return;

    if (typeof data === 'object') {
        state.data[path] = {
            data: data,
            timestamp: Date.now()
        };
    }
};

export const removeCachedData = (state, path) => {

    // 没有获得路径，则返回
    if (!path) return;

    delete state.data[path];
};