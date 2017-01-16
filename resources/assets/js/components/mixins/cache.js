// 过期时间，1min = 60s = 60000ms
const expire = 60 * 1000;

export default {
    computed: {
        cachedData () {
            let path = this.$route.path,
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