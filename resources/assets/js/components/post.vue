<template>
    <div>
        Post {{ $route.params.id }}
    </div>
</template>
<style lang="scss">


</style>
<script>

    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        //components:{
        //    'other-component':OtherComponent,
        //    HeaderComponent,
        //}
    }
</script>
