<template>
    <div class="container">
        <div class="sidebar header-sidebar">
            <div class="header-sidebar-panel">
                <b-header></b-header>
            </div>
        </div>

        <router-view></router-view>
    </div>
</template>
<script>
    import headerVue from './layout/Header';

    export default {
        components:{
            'b-header': headerVue,
        }
    }
</script>
