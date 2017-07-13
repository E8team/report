<template>
    <div>
        <TNav title="意见反馈"></TNav>
        <h2>感谢您的反馈，我们会尽快处理。</h2>
        <group title="反馈类型(单选)">
            <radio :options="feedbackTypes" v-model="data.feedback_type"></radio>
        </group>
        <group title="详细描述">
            <x-textarea :autosize="true" :max="1000" placeholder="请输入详细描述" :show-counter="true" v-model="data.content"></x-textarea>
        </group>
        <group title="联系方式">
            <x-switch title="匿名" v-model="anonymous"></x-switch>
            <x-input v-if="!anonymous" placeholder="请输入联系方式" title="联系方式" v-model="data.contact"></x-input>
        </group>
        <box gap="20px 20px">
            <x-button :disabled="disabled" @click.native="submit" type="primary">提交</x-button>
        </box>
        <loading v-model="loading" text="提交中"></loading>
    </div>
</template>

<script>
    import { Group, Radio, XTextarea, XSwitch, XInput, XButton, Box, Loading } from 'vux'
    import TNav from '../components/TNav.vue'
    export default {
        components: {
            Group, Radio, TNav, XTextarea, XSwitch, XInput, XButton, Box, Loading
        },
        computed: {
            disabled () {
                return this.data.content == '' || (!this.anonymous && this.data.contact == '')
            }
        },
        data () {
            return {
                value: '',
                anonymous: false,
                data: {
                    feedback_type: 0,
                    content: '',
                    contact: ''
                },
                feedbackTypes: [],
                loading: false
            }
        },
        mounted () {
            axios.get('/api/feedback_types').then(res => {
                this.feedbackTypes = res.data
            })
        },
        methods: {
            submit () {
                this.loading = true;
                axios.post('/api/feedback', {...this.data}).then(res => {
                    this.loading = false;
                    this.data = {
                        feedback_type: 0,
                        content: '',
                        contact: ''
                    }
                    this.$vux.alert.show({
                        title: '反馈成功',
                        content: '已经收到了您的反馈，我们将尽快处理。'
                    })
                }).catch(err => {
                    this.loading = false;
                    let content = '';
                    const errors = err.response.data.errors;
                    for(err in errors){
                        content += errors[err] + "<br />";
                    }
                    this.$vux.alert.show({
                        title: '出错了',
                        content
                    })
                })
            }
        }
    }
</script>

<style lang="less" scoped>
h2{
    font-size: 16px;
    margin-top: 15px;
    margin-left: 10px;
}
</style>