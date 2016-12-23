<template>
    <div>
        <vue-nav></vue-nav>

        <router-view></router-view>
    </div>
</template>
<style>
body {
  background-image: url(http://blog.ttionya.com/wp-content/uploads/2016/05/201605151132121234.jpg);
  background-size: cover;
  background-position-y: -100px;
  background-repeat: no-repeat;
}
</style>
<script>
    import navVue from './navigation';

    export default{
        components:{
            'vue-nav': navVue,
        }
    }
</script>
