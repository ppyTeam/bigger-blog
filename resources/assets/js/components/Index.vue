<template>
    <div class="container">
        <div class="sidebar header-sidebar">
            <div class="header-sidebar-panel">
                <b-nav></b-nav>
            </div>
        </div>

        <router-view></router-view>
    </div>
</template>
<script>
    import navVue from './layout/Header';

    export default {
        components:{
            'b-nav': navVue,
        }
    }
</script>
