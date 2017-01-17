export default {
    methods: {

        // ready 状态延迟时间，200ms
        getReady (readyDelay = 200) {
            setTimeout(() => this.ready = true, readyDelay);
        },


        setError (error) {

            // 没错误
            if (error === undefined) {
                this.error = { };

                return;
            }

            // 有错误
            this.error = {
                code: error.status,
                text: error.statusText
            };
        }
    }
};