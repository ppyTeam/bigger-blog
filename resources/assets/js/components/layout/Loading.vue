<template>
    <transition name="el-loading-fade">
        <div
                v-show="visible"
                class="el-loading-mask"
                :class="[customClass, { 'is-fullscreen': fullscreen }]">
            <div class="el-loading-spinner">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none"/>
                </svg>
                <p v-if="text" class="el-loading-text">{{ text }}</p>
            </div>
        </div>
    </transition>
</template>
<style scope lang="scss">
    .el-loading-mask {
        position: absolute;
        z-index: 10000;
        background-color: hsla(0,0%,100%,.9);
        margin: 0;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0
    }

    .el-loading-mask.is-fullscreen {
        position: fixed
    }

    .el-loading-mask.is-fullscreen .el-loading-spinner {
        margin-top: -25px
    }

    .el-loading-mask.is-fullscreen .el-loading-spinner .circular {
        width: 50px;
        height: 50px
    }

    .el-loading-spinner {
        top: 50%;
        margin-top: -21px;
        width: 100%;
        text-align: center;
        position: absolute;
    }

    .el-loading-spinner .el-loading-text {
        color: #20a0ff;
        margin: 3px 0;
        font-size: 14px
    }

    .el-loading-spinner .circular {
        width: 42px;
        height: 42px;
        animation: loading-rotate 2s linear infinite;
    }

    .el-loading-spinner .path {
        animation: loading-dash 1.5s ease-in-out infinite;
        stroke-dasharray: 90,150;
        stroke-dashoffset: 0;
        stroke-width: 8;
        stroke: #20a0ff;
        stroke-linecap: round;
    }

    @keyframes loading-rotate {
         to {
             transform: rotate(1turn);
         }
     }

    @keyframes loading-dash {
        0% {
            stroke-dasharray: 1,200;
            stroke-dashoffset: 0
        }

        50% {
            stroke-dasharray: 90,150;
            stroke-dashoffset: -40px
        }

        to {
            stroke-dasharray: 90,150;
            stroke-dashoffset: -120px
        }
    }
</style>
<script>
  export default {
    data() {
      return {
        text: null,
        fullscreen: false,
        visible: true,
        customClass: ''
      };
    },
    methods: {

    }
  };
</script>