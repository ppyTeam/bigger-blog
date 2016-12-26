<template>
    <div>
        <bb-nav></bb-nav>
    </div>
</template>
<style lang="scss" scoped>
.container {
  margin-top: 150px;
  text-align: center;

  img {
    height: 240px;
    opacity: .3;
  }
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
