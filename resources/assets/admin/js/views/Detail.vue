<template>
    <search
        @result-click="resultClick"
        @on-change="getResult"
        :results="results"
        v-model="keyword"
        position="absolute"
        auto-scroll-to-top
        @on-submit="onSubmit"
        ref="search">
    </search>
</template>

<script>
    import { Search } from 'vux'
    export default {
        components: {
            Search
        },
        data () {
            return {
                results: [],
                keyword: ''
            }
        },
        methods: {
            onSubmit () {
            },
            resultClick () {
            },
            getResult (val) {
                console.log(val)
            }
        }
    }
</script>

<style lang="less" scoped>

</style>