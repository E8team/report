<template>
    <div>
        <div class="circle_wrapper">
            <x-circle class="circle" :percent="30" :stroke-width="6" :trail-width="6" stroke-color="#3FC7FA" trail-color="#ececec">
                <span :style="{color: '#3FC7FA'}">{{overview.reported_student_count / overview.student_count}}%</span>
            </x-circle>
            <p>报到人数：{{Math.floor(overview.reported_student_count / overview.student_count * 100) / 100}}</p>
        </div>
        <load-more style="margin-bottom: 10px;" tip="各专业报到情况" :show-loading="false" background-color="#fbf9fe"></load-more>
        <x-table :cell-bordered="false" :content-bordered="false" style="background-color:#fff;">
            <thead>
            <tr style="background-color: #F7F7F7">
                <th>专业</th>
                <th>人数</th>
                <th>报到率</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in overview.majors">
                <td>{{item.title}}</td>
                <td>{{item.reported_student_count}}/{{item.student_count}}</td>
                <td>{{Math.floor(item.reported_student_count / item.student_count * 100) / 100}}%</td>
            </tr>
            </tbody>
        </x-table>
    </div>
</template>

<script>
    import { XCircle, LoadMore , XTable } from 'vux'
    export default{
        components: {
            XCircle, LoadMore, XTable
        },
        mounted () {
            this.$http.get('overview').then(res =>{
                this.overview = res.data;
            })
            this.timer = setInterval(() => {
                this.$http.get('overview', {
                    NoNProgress: true
                }).then(res =>{
                    this.overview = res.data;
                })
            }, 3000)
        },
        beforeDestroy () {
            if(this.timer)
                clearInterval(this.timer);
        },
        data () {
            return {
                overview: {},
                timer: null
            }
        }
    }
</script>

<style lang="less" scoped>
.circle_wrapper{
    margin: 30px 0 20px 0;
    >.circle{
        width: 100px;
        margin: 0 auto;
    }
    >p{
        margin-top: 15px;
        font-size: 16px;
        color: #333;
        text-align: center;
    }
}
</style>