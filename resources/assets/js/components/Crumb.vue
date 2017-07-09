<template>
<div class="crumb">
  <ul>
    <li v-link="{'name': item.href}" v-for="item in navList">
    {{item.title}}
    </li>
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