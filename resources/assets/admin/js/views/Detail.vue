<template>
    <div>
        <search
            @result-click="resultClick"
            @on-change="getResult"
            v-model="keyword"
            :results="results"
            auto-scroll-to-top
            ref="search">
        </search>
        <div class="tip">
            输入学生姓名或学号以修改
        </div>
    </div>
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
            resultClick (val) {
                this.keyword = /\d/.test(this.keyword[0]) ? val.student_num : val.student_name;
            },
            getResult (val) {
                this.$http.get(`students/${val}/search`).then(res => {
                    if(res.data){
                        res.data.forEach(item => {
                            item['title'] = `${item.student_name}(${item.student_num})`
                        })
                    }
                    this.results = res.data
                })
            }
        }
    }
</script>

<style lang="less" scoped>
    .tip{
        font-size: 14px;
        color: #666;
        padding: 10px;
    }
</style>