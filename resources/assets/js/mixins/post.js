export default {
    methods: {

        // 鼠标悬停在时间上的内容
        getDateTitle (created_at, updated_at) {
            if (!(created_at || updated_at)) return ''; // 容错


            let returnData = '';

            if (updated_at) returnData += '更新于 ' + updated_at + '\n';

            returnData += '创建于 ' + created_at;

            return returnData;
        },

        // 格式化时间为 yyyy-MM-dd 格式
        getFormationDate (date) {

            /*
             * 传入数据为 yyyy-MM-dd HH:mm:ss
             * 简单地取空格前日期即可，以后有变化再进行修改
             */

            return date.split(' ')[0];


            // // IE and Safari bug
            // date = date.replace(/-/g, '/');
            //
            // let mm, dd;
            //
            // date = new Date(date);
            // mm = ('0' + (date.getMonth() + 1)).slice(-2);
            // dd = ('0' + date.getDate()).slice(-2);
            //
            // return date.getFullYear() + '-' + mm + '-' + dd;
        },

        // 计算浏览人数 （已移除该功能，暂不删除）
        // 根据实际情况，暴力实现即可，最高支持到 千亿 级别
        // getFormationViewCount (count = 0) {
        //     if (isNaN(parseInt(count))) return 0; // 容错
        //
        //
        //     let digit = count.toString().split('').length;
        //
        //     if (digit < 5) {
        //         return count;
        //     }
        //     else if (digit < 9) {
        //         return parseInt(count / 1e4) + ' 万';
        //     }
        //     else if (digit < 13) {
        //         return parseInt(count / 1e8) + ' 亿';
        //     }
        //     else {
        //         return '爆表';
        //     }
        // }
    },

    computed: {

    }
};