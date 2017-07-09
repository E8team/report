<template>
    <div>
        <router-view></router-view>
    </div>
</template>


<script>
    export default{
        name: 'app',
        components: {
        },
        mounted () {
        }
    }
</script>

<style lang="less">
    @import '~vux/src/styles/reset.less';
    html,body{
        font-size: 20px;
    }
    body{
        background-color: #f5f5f5;
    }
    *{
        box-sizing: border-box;
    }
    ul, li{
        list-style: none;
    }
    @font-face {font-family: "iconfont";
        src: url('../fonts/iconfont.eot?t=1470466667'); /* IE9*/
        src: url('../fonts/iconfont.eot?t=1470466667#iefix') format('embedded-opentype'), /* IE6-IE8 */
        url('../fonts/iconfont.woff?t=1470466667') format('woff'), /* chrome, firefox */
        url('../fonts/iconfont.ttf?t=1470466667') format('truetype'), /* chrome, firefox, opera, Safari, Android, iOS 4.2+*/
        url('../fonts/iconfont.svg?t=1470466667#iconfont') format('svg'); /* iOS 4.1- */
    }

    .iconfont {
        font-family:"iconfont" !important;
        font-size:16px;
        font-style:normal;
        -webkit-font-smoothing: antialiased;
        -webkit-text-stroke-width: 0.2px;
        -moz-osx-font-smoothing: grayscale;
    }
    .icon-jiantou:before { content: "\e600"; }
    .icon-chuang:before { content: "\e602"; }
    .icon-backspace:before { content: "\e601"; }
</style>