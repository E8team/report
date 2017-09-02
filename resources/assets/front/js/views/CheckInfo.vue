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
        <box gap="20px 20px">
            <x-button plain @click.native="confirm" type="primary">确认报道</x-button>
        </box>
    </div>
</template>

<script>
    import { Group, Cell, XButton, Box } from 'vux'
    import TNav from '../../../common/components/TNav.vue'
    export default{
        components: {
           Group, Cell, XButton, TNav, Box
        },
        data () {
            return {
                studentInfo: {
                    student_profile: {
                        data: {}
                    }
                }
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
                const _this = this;
                this.$vux.confirm.show({
                    title: '确认报到？',
                    content: '请确认信息是否正确',
                    onCancel () {},
                    onConfirm () {
                        _this.$http.post('set_report').then(res => {
                            _this.$router.push('/report_ok')
                        });
                    }
                })
            }
        }
    }
</script>