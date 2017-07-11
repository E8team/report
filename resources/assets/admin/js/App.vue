<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default{
    data () {
        return {}
    }
}
</script>

<style lang="less">
    @import '~vux/src/styles/reset.less';
    html,body{
        font-size: 20px;
    }

    *{
        box-sizing: border-box;
    }
    ul, li{
        list-style: none;
    }
</style>
