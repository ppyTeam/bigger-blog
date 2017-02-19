<template>
    <div class="container" :class="{'header-in': navHeaderState }">
        <div class="sidebar header-sidebar">
            <b-header></b-header>
        </div>

        <router-view></router-view>
    </div>
</template>
<script>
    import headerVue from './layout/Header';

    export default {
        components:{
            'b-header': headerVue
        },

        computed: {
            navHeaderState () {
                return !this.$store.state.navHeaderState;
            }
        }
    }
</script>
