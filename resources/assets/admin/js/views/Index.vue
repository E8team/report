<template>
    <div>
        <div class="circle_wrapper">
            <x-circle class="circle" :percent="30" :stroke-width="6" :trail-width="6" stroke-color="#3FC7FA" trail-color="#ececec">
                <span :style="{color: '#3FC7FA'}">30%</span>
            </x-circle>
            <p>报到人数：30/420</p>
        </div>
        <load-more style="margin-bottom: 10px;" tip="各班报到情况" :show-loading="false" background-color="#fbf9fe"></load-more>
        <x-table :cell-bordered="false" :content-bordered="false" style="background-color:#fff;">
            <thead>
            <tr style="background-color: #F7F7F7">
                <th>班级</th>
                <th>人数</th>
                <th>报到率</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>网工1班</td>
                <td>10/32</td>
                <td>33.3%</td>
            </tr>
            <tr>
                <td>网工1班</td>
                <td>10/32</td>
                <td>33.3%</td>
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
        data () {
            return {
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