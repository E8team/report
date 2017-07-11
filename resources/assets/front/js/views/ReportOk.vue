<template>
    <div class="report_ok">
        <TNav title="报到成功"></TNav>
        <msg title="报到成功" description="恭喜你，报到成功。现在你可以选择宿舍" :buttons="buttons" :icon="icon"></msg>
    </div>
</template>



<script>
    import { Msg } from 'vux'
    import TNav from '../components/TNav.vue'
    export default {
        components: {
            Msg, TNav
        },
        methods: {
        },
        mounted () {
            document.title = '报到成功'
        },
        data () {
            const _this = this;
            return {
                icon: '',
                buttons: [{
                    type: 'primary',
                    text: '选择宿舍',
                    onClick () {
                        _this.$router.push('/select_dorm')
                    }
                }]
            }
        }
    }
</script>
<style scoped lang="less">
    .report_ok{
        height: 100%;
        background-color: #fcfcfc;
    }
</style>