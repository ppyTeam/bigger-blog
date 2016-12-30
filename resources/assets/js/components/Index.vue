<template>
    <div class="index container">
        <b-nav></b-nav>

        <router-view></router-view>
    </div>
</template>
<script>
    import navVue from './Navigation';

    export default {
        components:{
            'b-nav': navVue,
        }
    }
</script>
