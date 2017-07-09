<template>
    <div>
        <t-nav bgcolor="#f5f5f5" title="9A430"></t-nav>
        <crumb :nav-list="navList"></crumb>
        <div class="people">
            <header>已入住9A430的同学</header>
            <div class="null" v-if="students.length == 0">
                暂无人选择该宿舍
            </div>
            <ul>
                <li v-for="student in students">
                    <div class="has_class">
                        {{student.student_name}}
                        <span class="classes">15级网工2班</span>
                    </div>
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
        mounted () {
            this.$http.get(`dormitories/${this.$route.params.id}/students`).then(res => {
                this.students = res.data.data;
            })
        },
        methods: {
            confirm () {
                const _this = this;
                this.$vux.confirm.show({
                    title: '确认选择该宿舍？',
                    content: '',
                    onCancel () {},
                    onConfirm () {
                        _this.$http.post(`select_dorm/${_this.$route.params.id}`).then(res => {
                            //todo 选择成功
                        }).catch(e => {
                            _this.$vux.toast.show({
                                text: e.response.data.message,
                                type: 'warn'
                            })
                        });
                    }
                })
            }
        },
        data () {
            return {
                students: [],
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
    >.null{
        line-height: 120px;
        font-size: 14px;
        color: #666;
        text-align: center;
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