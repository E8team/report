<template>
  <div class="register">
    <div class="logo">
        <img src="../../images/logo_admin.png" alt="">
    </div>
    <group title="请填写正确的身份信息">
      <x-input title="登录帐号:" v-model="formData.user_name"></x-input>
      <x-input title="姓　　名:" v-model="formData.name"></x-input>
      <x-input title="密　　码:" type="password" v-model="formData.password"></x-input>
      <x-input title="确认密码:" type="password" v-model="formData.password_confirmation"></x-input>
      <selector title="所属学院" v-model="formData.department_id" :options="allDepartments"></selector>
      <selector title="所属部门" v-model="formData.role" :options="[{key: 'dz' ,value: '党站'}, {key: 'xsh' ,value: '学生会'}]"></selector>
    </group>
    <Box gap="30px 20px">
        <x-button type="primary" @click.native="submit">注册</x-button>
    </Box>
  </div>
</template>

<script>
import { XInput, Group, Selector, Box, XButton } from 'vux'
export default {
  components: { XInput, Group, Selector, Box, XButton },
  data () {
    return {
      allDepartments: [],
      formData: {
        user_name: '',
        name: '',
        password: '',
        password_confirmation: '',
        department_id: null,
        role: null
      }
    };
  },
  methods: {
    submit () {
      // todo 报错信息
      this.$http.post('register', this.formData).then(res => {
        this.$router.push({name: 'register_ok'});
      })
    }
  },
  mounted () {
    this.$http.get('all_departments').then(res => {
      this.allDepartments = res.data.data.map(item => {
        return {
          key: item.id,
          value: item.title
        }
      });
    })
  }
};
</script>

