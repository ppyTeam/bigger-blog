<template>
    <div class="container">
        <b-nav></b-nav>

        <router-view></router-view>
    </div>
</template>
<script>
    import navVue from './layout/Navigation';

    export default {
        components:{
            'b-nav': navVue,
        }
    }
</script>
