<template>
  <x-header :transition="headerTransition" :left-options="{showBack: showBack, backText: ''}" :style="{'background-color':bgcolor}">
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
    computed:{
      ...mapState({
        direction: state => state.direction
      }),
      headerTransition () {
          return this.direction === 'forward' ? 'vux-header-fade-in-right' : 'vux-header-fade-in-left'
      },
    },
    data () {
      return {
      }
    }
  }
</script>

<style scoped>

</style>
