<template>
    <div>
        <bb-nav></bb-nav>

        <div class="content-box">
            <router-view></router-view>
        </div>
    </div>
</template>
<style lang="scss">
.content-box {
    margin: 40px 30px 0 380px;
}
</style>
<script>
    import navVue from './Navigation';

    export default {
        components:{
            'bb-nav': navVue,
        }
    }
</script>
