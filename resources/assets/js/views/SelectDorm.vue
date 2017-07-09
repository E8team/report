<template>
    <div>
        <t-nav title="选择宿舍" :show-back="false"></t-nav>
        <crumb :nav-list="navList"></crumb>
    </div>
</template>


<script>
    import Crumb from '../components/Crumb.vue'
    export default{
        name: 'SelectDorm',
        components: {
            Crumb
        },
        mounted () {
        },
        data () {
            return {
                navList: [
                    {
                        title: '选择宿舍',
                        href: 'selectdorm'
                    }
                ]
            }
        }
    }
</script>

<style lang="less" scoped>

</style>