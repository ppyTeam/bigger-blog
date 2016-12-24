<template>
    <div class="nav">
        <router-link to="/">
            <img class="logo" src="http://ttionya.qiniudn.com/LOGO.gif" />
        </router-link>
        <nav>
            <ul>
                <li><router-link to="/">Home</router-link></li>
                <li><router-link to="/blog">List</router-link></li>
                <li><router-link to="/blog/1">Post 1</router-link></li>
                <li><router-link to="/blog/2">Post 2</router-link></li>
                <li><router-link to="/blog/3">Post 3</router-link></li>
            </ul>
        </nav>
    </div>
</template>
<style lang="scss">
.nav {
  position: fixed;
  height: 100%;
  width: 350px;
  background-color: #f5f5f5;
  filter: opacity(.8);

  .logo {
    display: block;
    width: 112px;
    margin: 50px auto;
    border: 1px #DDD solid;
    border-radius: 500px;
    background-color: #fff;
  }

  ul {
    font-size: 2rem;
    list-style: none;

    li {
      margin: 5px;
    }
  }
}
</style>
<script>
    export default{
        //data(){
        //    return{
        //        msg:'hello vue'
        //    }
        //},
        //components:{
        //    'other-component':OtherComponent,
        //    HeaderComponent,
        //}
    }
</script>
