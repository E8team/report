<template>
    <div class="people">
        <header>已入住{{dormNum}}的同学</header>
        <div class="null" v-if="students.length == 0">
            暂无人选择该宿舍
        </div>
        <ul>
            <li v-for="student in students">
                <div class="has_class">
                    {{student.student_name}}
                    <span class="classes">15级网工2班</span>
                </div>
            </li>
        </ul>
    </div>
</template>
<script>
    export default {
        props: {
            dorm_id: String,
        },
        mounted () {
            if(this.dorm_id != undefined){
                this.getStudents();
            }
        },
        methods: {
            getStudents () {
                this.$http.get(`dormitories/${this.dorm_id}/students`).then(res => {
                    this.students = res.data.data;
                    this.dormNum = res.data.meta.dorm_num;
                    this.$emit('update:dorm_num', this.dormNum);
                })
            }
        },
        watch: {
            dorm_id () {
                this.getStudents();
            }
        },
        data () {
            return {
                dormNum: '',
                students: []
            }
        }
    }
</script>

<style lang="less" scoped>
    .people {
        margin-top: 15px;
        background-color: #fff;
        >header{
            margin: 0 10px;
            padding-left: 5px;
            line-height: 35px;
            font-size: 14px;
            border-bottom: 1px solid #F5F5F5;
        }
        >.null{
            line-height: 120px;
            font-size: 14px;
            color: #666;
            text-align: center;
        }
        > ul {
            overflow: hidden;
            > li {
                float: left;
                width: 33.33%;
                padding: 10px;
                > div {
                    font-size: 16px;
                    color: #333;
                    border-radius: 4px;
                    background-color: #f9f9f9;
                    line-height: 60px;
                    text-align: center;
                    position: relative;
                    &.has_class{
                        height: 60px;
                        line-height: 50px;
                    }
                    &:active{
                        background-color: #f5f5f5;
                    }
                    .classes{
                        font-size: 12px;
                        position: absolute;
                        bottom: 5px;
                        left: 0;
                        color: #999;
                        line-height: normal;
                        width: 100%;
                        text-align: center;
                    }
                }

            }
        }
    }
</style>