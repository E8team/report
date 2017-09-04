<template>
  <div class="register">
    <div class="logo">
        <img src="../../images/logo_admin.png" alt="">
    </div>
    <group title="请填写正确的身份信息">
      <x-input title="姓　　名:"></x-input>
      <x-input title="密　　码:"></x-input>
      <x-input title="确认密码:"></x-input>
      <selector title="所属学院" :options="['计算机']"></selector>
      <selector title="所属部门" :options="['党站', '学生会']"></selector>
    </group>
    <Box gap="30px 20px">
        <x-button type="primary">注册</x-button>
    </Box>
  </div>
</template>

<script>
import { XInput, Group, Selector, Box, XButton } from 'vux'
export default {
  components: { XInput, Group, Selector, Box, XButton }
};
</script>

