<template>
    <div>
        <router-view></router-view>
        <tabbar class="tabbar" v-if="$route.name !== 'login'">
            <tabbar-item link="/admin/index">
                <img slot="icon" src="../images/all.png">
                <span slot="label">总览</span>
            </tabbar-item>
            <tabbar-item link="/admin/detail">
                <img slot="icon" src="../images/set.png">
                <span slot="label">管理</span>
            </tabbar-item>
            <tabbar-item link="/admin/set_arrive_dorm">
                <img slot="icon" src="../images/form.png">
                <span slot="label">设置到宿</span>
            </tabbar-item>
            <tabbar-item link="/admin/feed_back">
                <img slot="icon" src="../images/edit.png">
                <span slot="label">反馈</span>
            </tabbar-item>
        </tabbar>
    </div>
</template>

<script>
    import { Tabbar, TabbarItem } from 'vux'
    export default{
        components: {
            Tabbar, TabbarItem
        },
        data () {
            return {}
        }
    }
</script>

<style lang="less">
    @import '~vux/src/styles/reset.less';
    html,body{
        background-color: #FBF9FE;
    }
    body{
        padding-bottom: 60px;
    }
    *{
        box-sizing: border-box;
    }
    ul, li{
        list-style: none;
    }
    .tabbar{
        position: fixed!important;
    }
</style>
