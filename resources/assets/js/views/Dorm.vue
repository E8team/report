<template>
    <div>
        <t-nav bgcolor="#f5f5f5" title="9A430"></t-nav>
        <crumb :nav-list="navList"></crumb>
        <div class="people">
            <header>已入住9A430的同学</header>
            <ul>
                <li>
                    <div>陶炜</div>
                </li>
                <li>
                    <div class="has_class">
                        秦志强
                        <span class="classes">15级网工2班</span>
                    </div>
                </li>
                <li>
                    <div>于皖虎</div>
                </li>
                <li>
                    <div>田阳</div>
                </li>
            </ul>
        </div>
        <box gap="20px 20px">
            <x-button @click.native="confirm" type="primary">选择该宿舍</x-button>
            <x-button plain @click.native="$router.back()">返回</x-button>
        </box>
    </div>
</template>

<script>
    import { XButton, Box } from 'vux'
    import Crumb from '../components/Crumb.vue'
    export default {
        components: {
            XButton, Box, Crumb
        },
        data () {
            return {
                navList: [
                    {
                        title: '选择宿舍',
                        href: '/select_dorm'
                    },
                    {
                        title: '9A430',
                        href: '/select_dorm'
                    }
                ]
            }
        }
    }
</script>

<style scoped lang="less">
.people {
    margin-top: 15px;
    background-color: #fff;
    >header{
        margin: 0 10px;
        padding-left: 5px;
        line-height: 35px;
        font-size: 14px;
        border-bottom: 1px solid #F5F5F5;
    }
    > ul {
        overflow: hidden;
        > li {
            float: left;
            width: 33.33%;
            padding: 10px;
            > div {
                font-size: 16px;
                color: #333;
                border-radius: 4px;
                background-color: #f9f9f9;
                line-height: 60px;
                text-align: center;
                position: relative;
                &.has_class{
                    height: 60px;
                    line-height: 50px;
                }
                &:active{
                    background-color: #f5f5f5;
                }
                .classes{
                    font-size: 12px;
                    position: absolute;
                    bottom: 5px;
                    left: 0;
                    color: #999;
                    line-height: normal;
                    width: 100%;
                    text-align: center;
                }
            }

        }
    }
}
</style>