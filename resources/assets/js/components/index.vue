<template>
    <div>
        <bb-nav></bb-nav>

        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>
<style>
.content {
  margin-left: 350px;
  padding: 50px 20px 0 20px;
}
</style>
<script>
    import navVue from './navigation';

    export default{
        components:{
            'bb-nav': navVue,
        }
    }
</script>
