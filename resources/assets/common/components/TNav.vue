<template>
  <x-header :left-options="{showBack: showBack, backText: ''}" :style="{'background-color':bgcolor}">
    <span :style="{'color': textcolor}">{{title}}</span>
  </x-header>
</template>

<script>
  import { XHeader } from 'vux'
  import { mapState } from 'vuex'
  export default {
    name: 'TNav',
    components: {
      XHeader
    },
    props: {
      // 导航栏颜色
      bgcolor: {
        type: String,
        default: '#fff'
      },
      textcolor: {
        type: String,
        default: '#333'
      },
      title: String,
      showBack: {
        type: Boolean,
        default: true
      }
    },
    data () {
      return {
      }
    }
  }
</script>

<style scoped>

</style>
