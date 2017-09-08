<template>
    <div class="class_Detail">
        <TNav :title="className"></TNav>
        <x-table 
        :cell-bordered="false" 
        :content-bordered="false" 
        style="background-color:#fff;">
            <thead>
            <tr style="background-color: #F7F7F7">
                <th>宿舍号</th>
                <th>已入住</th>
                <th>可入住</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in dormitories">
                <td>{{item.dorm_num}}</td>
                <td>{{item.already_selected_num_in_this_class}}</td>
                <td>{{item.galleryful_in_this_class}}</td>
            </tr>
            </tbody>
        </x-table>
        <load-more style="margin-bottom: 10px;" tip="班级详情" :show-loading="false" background-color="#fbf9fe"></load-more>
        <tab>
            <tab-item selected @on-item-click="isReport = true">已报到</tab-item>
            <tab-item @on-item-click="isReport = false">未报到</tab-item>
        </tab>
        <PullDownLoading ref="list" @on-class-name="cName => className = cName" :query="`department_class/${$route.params.id}/students?include=dormitory${isReport ? '&is_report=true' : ''}`" style="padding-bottom: 60px;">
            <template scope="students">
                <x-table 
                :cell-bordered="false" 
                :content-bordered="false" 
                style="background-color:#fff;">
                    <thead>
                    <tr style="background-color: #F7F7F7">
                        <th>姓名</th>
                        <th>性别</th>
                        <th>宿舍</th>
                        <th>床位</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in students.data">
                        <td>{{item.student_name}}</td>
                        <td>{{item.gender_str}}</td>
                        <td>{{item.dormitory.data.dorm_num ? item.dormitory.data.dorm_num : '无'}}</td>
                        <td>{{item.dormitory.data.bed_num ? item.dormitory.data.bed_num : '无'}}</td>
                    </tr>
                    </tbody>
                </x-table>
            </template>
        </PullDownLoading>
    </div>
</template>

<script>
import { Tab, TabItem, LoadMore , XTable } from 'vux'
import TNav from '../../../common/components/TNav.vue'
import PullDownLoading from '../components/PullDownLoading.vue'
export default{
    components: { TNav, Tab, TabItem, LoadMore , XTable, PullDownLoading },
    data () {
        return {
            dormitories: [],
            isReport: true,
            className: ''
        };
    },
    watch: {
        'isReport' () {
            this.$nextTick(() => {
                this.$refs.list.update();
            });
        }
    },
    mounted () {
        this.$http.get(`department_class/${this.$route.params.id}/dormitories`).then(res => {
            this.dormitories = res.data.data;
        })
    }
}
</script>

<style lang="less" scoped>

</style>
