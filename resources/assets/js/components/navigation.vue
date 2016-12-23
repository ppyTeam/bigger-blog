<template>
    <nav>
        <ul>
            <li><router-link to="/blog">Home</router-link></li>
            <li><router-link to="/blog/1">1</router-link></li>
            <li><router-link to="/blog/2">2</router-link></li>
        </ul>
    </nav>

</template>
<style>
ul {
  list-style: none;
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
