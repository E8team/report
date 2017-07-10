<template>
    <div>
        <t-nav bgcolor="#f5f5f5" :title="dormNum"></t-nav>
        <crumb :nav-list="navList"></crumb>
        <DormPoeple :dorm_id="String($route.params.id)" :dorm_num.sync="dormNum"></DormPoeple>
        <box gap="20px 20px">
            <x-button @click.native="confirm" type="primary">选择该宿舍</x-button>
            <x-button plain @click.native="$router.back()">返回</x-button>
        </box>
    </div>
</template>

<script>
    import { XButton, Box } from 'vux'
    import Crumb from '../components/Crumb.vue'
    import DormPoeple from '../components/DormPoeple.vue'
    export default {
        components: {
            XButton, Box, Crumb, DormPoeple
        },
        mounted () {
        },
        watch: {
            'dormNum' () {
                this.navList.push({
                    title: this.dormNum,
                    href: this.$route.path
                })
            }
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
                        })
                    }
                })
            }
        },
        data () {
            return {
                dormNum: '',
                navList: [
                    {
                        title: '选择宿舍',
                        href: '/select_dorm'
                    }
                ]
            }
        }
    }
</script>

<style scoped lang="less">

</style>