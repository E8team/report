<template>
    <div>
        <div class="circle_wrapper">
            <x-circle class="circle" :percent="Number((overview.reported_student_count / overview.student_count * 100).toFixed(2))" :stroke-width="6" :trail-width="6" stroke-color="#3FC7FA" trail-color="#ececec">
                <span :style="{color: '#3FC7FA'}">{{(overview.reported_student_count / overview.student_count * 100).toFixed(2)}}%</span>
            </x-circle>
            <p>报到人数：{{overview.reported_student_count }}/{{overview.student_count}}</p>
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
                <td>{{(item.reported_student_count / item.student_count * 100).toFixed(2)}}%</td>
            </tr>
            </tbody>
        </x-table>
        <load-more style="margin-bottom: 10px;" tip="各班级报到情况" :show-loading="false" background-color="#fbf9fe"></load-more>
        <x-table :cell-bordered="false" :content-bordered="false" style="background-color:#fff;">
            <thead>
            <tr style="background-color: #F7F7F7">
                <th>班级</th>
                <th>人数</th>
                <th>报到率</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in overview.classes">
                <td>{{item.title}}</td>
                <td>{{item.reported_student_count}}/{{item.student_count}}</td>
                <td>{{(item.reported_student_count / item.student_count * 100).toFixed(2)}}%</td>
            </tr>
            </tbody>
        </x-table>
        <group v-if="logs.length > 0" title="logs">
            <div class="log">
                <p v-for="log in logs">
                    {{log.content}} <span class="time">{{$dateFormat(log.created_at, 'MM-DD HH:mm:ss')}}</span>
                </p>
            </div>
        </group>
    </div>
</template>

<script>
    import { XCircle, LoadMore , XTable, Group, dateFormat } from 'vux'
    import { mapState } from 'vuex'
    export default{
        components: {
            XCircle, LoadMore, XTable, Group
        },
        computed: {
            ...mapState({
                departmentId: state => state.departmentId
            })
        },
        mounted () {
            this.$dateFormat = dateFormat;
            this.$http.get(`overview/${this.departmentId}`).then(res =>{
                this.overview = res.data;
            })
            this.$http.get(`logs/${this.departmentId}`, {
                NoNProgress: true
            }).then(res => {
                this.logs = res.data.data;
            })
            this.timer = setInterval(() => {
                this.$http.get(`overview/${this.departmentId}`, {
                    NoNProgress: true
                }).then(res =>{
                    this.overview = res.data;
                })
                this.$http.get(`logs/${this.departmentId}`, {
                    NoNProgress: true
                }).then(res => {
                    this.logs = res.data.data;
                })
            }, 3000);
        },
        beforeDestroy () {
            if(this.timer)
                clearInterval(this.timer);
        },
        data () {
            return {
                overview: {},
                timer: null,
                logs: []
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
.log{
    background-color: #fff;
    padding: 10px;
    font-size: 14px;
    color: #666;
    >p{
        line-height: 26px;
        padding-right: 100px;
        position: relative;
        margin-bottom: 10px;
        &:last-child{
            margin-bottom: 0;
        }
        >.time{
            top: 0;
            position: absolute;
            right: 0;
            font-size: 12px;
            color: #999;
        }
    }
}
</style>