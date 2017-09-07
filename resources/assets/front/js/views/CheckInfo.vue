<template>
    <div>
        <TNav title="确认信息"></TNav>
        <group>
            <cell title="学号" :value="studentInfo.student_num"></cell>
            <cell title="姓名" :value="studentInfo.student_name"></cell>
            <cell title="性别" :value="studentInfo.gender ? '女' : '男'"></cell>
            <cell title="班级" :value="studentInfo.department_class"></cell>
            <!--<cell title="联系电话" :value="studentInfo.student_profile.data.tel"></cell>-->
            <cell title="生源地" :value="studentInfo.student_profile.data.place_of_student"></cell>
            <cell title="身份证" :value="studentInfo.id_card_with_mosaic"></cell>
            <!--<cell title="毕业中学" :value="studentInfo.student_profile.data.graduate_school"></cell>-->
        </group>
        <group title="我们收集身高体重信息用于定制校服，请一定注意身高的单位是厘米,体重的单位是斤！！！">
            <x-input required title="身高(cm):" type="number" v-model.number="height"></x-input>
            <x-input required title="体重(斤):" type="number" v-model.number="weight"></x-input>
        </group>
        <box gap="20px 20px">
            <x-button plain @click.native="confirm" type="primary">确认报道</x-button>
        </box>
    </div>
</template>

<script>
    import { Group, Cell, XButton, Box, XInput } from 'vux'
    import TNav from '../../../common/components/TNav.vue'
    export default{
        components: {
           Group, Cell, XButton, TNav, Box, XInput
        },
        data () {
            return {
                studentInfo: {
                    student_profile: {
                        data: {}
                    }
                },
                height: null,
                weight: null
            }
        },
        mounted () {
            document.title = '确认报到'
            this.$http.get('me?include=student_profile,dormitory').then(res => {
                this.studentInfo = res.data.data
                if(this.studentInfo.dormitory.data.length !== 0){
                    this.$router.replace({name: 'final'});
                }else if(this.studentInfo.report_at !== null){
                    this.$router.replace({name: 'report_ok'});
                }
            })
        },
        methods: {
            confirm () {
                if (!this.height) {
                    Vue.$vux.toast.show({
                        text: '请填写身高!',
                        type: 'warn'
                    })
                    return;
                }
                if (!this.weight) {
                    Vue.$vux.toast.show({
                        text: '请填写体重!',
                        type: 'warn'
                    })
                    return;
                }
                const _this = this;
                this.$vux.confirm.show({
                    title: '确认报到？',
                    content: '请确认信息是否正确',
                    onCancel () {},
                    onConfirm () {
                        _this.$http.post('set_report', {
                            height: _this.height,
                            weight: _this.weight
                        }).then(res => {
                            _this.$router.push('/report_ok')
                        }).catch(err => {
                            if (err.response.status === 422) {
                                const errors = err.response.data.errors;
                                let messageText = '';
                                for(let index in errors){
                                    messageText += (errors[index] + '<br/>');
                                }
                                _this.$vux.alert.show({
                                    title: '输入有误',
                                    content: messageText
                                })
                            }
                        });
                    }
                })
            }
        }
    }
</script>