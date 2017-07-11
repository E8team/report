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
        background-color: #f5f5f5;
    }
    *{
        box-sizing: border-box;
    }
    ul, li{
        list-style: none;
    }
</style>
