<template>
<div class="crumb">
  <ul>
    <router-link :to="{'path': item.href}" tag="li" v-for="(item, index) in navList" :key="index">
    {{item.title}}
    </router-link>
  </ul>
</div>
</template>

<script>
export default {
  name: 'Crumb',
  props: {
    navList: Array
  },
  data () {
    return {
    }
  }
}
</script>

<style lang="less" scoped>
  .crumb{
    height: 40px;
    background-color: #fff;
    >ul{
      >li{
        font-size: 12px;
        float: left;
        line-height: 40px;
        padding: 0 10px;
        position: relative;
        color:#666;
        &::after{
          content: '\e600';
          position:absolute;
          font-size: 14px;
          top:0;
          right: -5px;
          color:#ccc;
          font-family:"iconfont" !important;
          font-style:normal;
          -webkit-font-smoothing: antialiased;
          -webkit-text-stroke-width: 0.2px;
          -moz-osx-font-smoothing: grayscale;
        }
      }
    }
  }
</style>