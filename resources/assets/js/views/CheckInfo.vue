<template>
    <div>
        <TNav title="确认信息"></TNav>
        <group>
            <cell title="学号" :value="userInfo.student_num"></cell>
            <cell title="姓名" :value="userInfo.student_name"></cell>
            <cell title="性别" :value="userInfo.gender_title"></cell>
            <cell title="班级" :value="userInfo.student_class ? userInfo.student_class.class_name.short_name : ''"></cell>
            <cell title="联系电话" :value="userInfo.tel"></cell>
            <cell title="身份证" :value="userInfo.id_card"></cell>
            <cell title="毕业中学" :value="userInfo.graduate_school"></cell>
        </group>
    </div>
</template>

<script>
    import { Group, Cell, XButton } from 'vux'
    import TNav from '../components/TNav.vue'
    export default{
        components: {
           Group, Cell, XButton, TNav
        },
        data () {
            return {
                userInfo: {}
            }
        },
        mounted () {
            this.$http.get('me').then(res => {
                console.log(res)
                // this.userInfo = res.data
            })
        }
    }
</script>