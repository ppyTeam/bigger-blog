// 过期时间，1min = 60s = 60000ms
const expire = 60 * 1000;

export default {
    methods: {
        getCachedListPath (route) {
            const ROUTER_NAME = ['blog', 'tag', 'category']; // Router name is 'blog', 'tag' or 'category'

            let paramName = route.params.name,
                paramPage = route.params.page,
                path = route.path;

            if (ROUTER_NAME.indexOf(paramName) !== -1 && paramPage === undefined) {
                path += '/page/1';
            }

            return path;
        }
    },


    computed: {
        cachedData () {
            let path = this.getCachedListPath(this.$route),
                cachedData = this.$store.state.data[path];

            if (!cachedData) return null;

            if (cachedData.timestamp <= Date.now() - expire) {
                this.$store.commit('removeCachedData', path); // 移除

                return null;
            }

            return cachedData.data;
        }
    }
};