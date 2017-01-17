<template>
    <div class="error-box">
        <div class="error-frosted-glass"></div>
        <div class="error">
            <h4>{{ errorMsg }}</h4>
            <p class="error-text">Try to <a href="" @click.prevent="reload">Reload</a> this page. Or <a href="" @click.prevent="goBack">Go Back</a></p>
        </div>
    </div>
</template>
<script>
    export default {
        props: [
            'error'
        ],


        methods: {
            reload () {
                this.$emit('reload');
            },
            goBack: () => history.go(-1)
        },


        computed: {
            errorMsg () {
                let errorText = this.error.text,
                    errorCode = this.error.code;

                if (errorCode === 0) return '未知错误。错误代码：0';

                return errorText + '。错误代码：' + errorCode;
            }
        }
    }
</script>