<template>
    <div class="register_ok">
        <msg title="注册成功" description="恭喜你，注册成功。" :icon="icon"></msg>
    </div>
</template>



<script>
    import { Msg } from 'vux'
    export default {
        components: { Msg },
        methods: {
        },
        data () {
            return {
                icon: '',
            }
        }
    }
</script>
<style scoped lang="less">
    .register_ok{
        height: 100%;
        background-color: #fcfcfc;
    }
</style>