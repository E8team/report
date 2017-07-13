<template>
    <div>
        <TNav title="意见反馈"></TNav>
        <h2>感谢您的反馈，我们会尽快处理。</h2>
        <group title="反馈类型">
            <radio :options="[{key: '001',value: 'radio001'}, {key: '002',value: 'radio002'}]" v-model="value"></radio>
        </group>
        <group title="详细描述">
            <x-textarea :autosize="true" :max="1000" placeholder="请输入详细描述" :show-counter="true" v-model="value"></x-textarea>
        </group>
        <group title="联系方式">
            <x-switch title="匿名" v-model="anonymous"></x-switch>
            <x-input v-if="!anonymous" placeholder="请输入联系方式" title="联系方式" v-model="value"></x-input>
        </group>
        <box gap="20px 20px">
            <x-button @click.native="submit" type="primary">提交</x-button>
        </box>
    </div>
</template>

<script>
    import { Group, Radio, XTextarea, XSwitch, XInput, XButton, Box } from 'vux'
    import TNav from '../components/TNav.vue'
    export default {
        components: {
            Group, Radio, TNav, XTextarea, XSwitch, XInput, XButton, Box
        },
        data () {
            return {
                value: '',
                anonymous: false
            }
        },
        methods: {
            submit () {
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