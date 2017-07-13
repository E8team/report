<template>
    <div>
        <search @on-change="change" @on-cancel="onCancel" @on-focus="onFocus" v-model="keyword" :auto-fixed="false" placeholder="可按姓名，学号，拼音搜索"></search>
        <group>
            <cell @click.native="setArrive(item, index)" is-link :key="item.id" v-for="(item, index) in notArriveDormStudents" :title="item.student_name">{{item.student_num}}</cell>
        </group>
    </div>
</template>

<script>
    import { Group, Cell, Search } from 'vux';
    export default{
        components: {
            Group, Cell, Search
        },
        methods: {
            onFocus () {
                this.keyword = '';
                if(this.timer)
                    clearInterval(this.timer);
            },
            onCancel () {
                this.ajaxRefreshStart();
            },
            change (newVal) {
                this.notArriveDormStudents = this.originalNotArriveDormStudents.filter(item =>
                    (item.student_name.indexOf(newVal) === 0 ||
                    item.abbreviation_pinyin1.indexOf(newVal) === 0  ||
                    item.abbreviation_pinyin2.indexOf(newVal) === 0  ||
                    item.full_pinyin1.indexOf(newVal) === 0  ||
                    item.full_pinyin2.indexOf(newVal) === 0  ||
                    item.student_num.indexOf(newVal) === 0));
            },
            setArrive (student, index) {
                const _this = this;
                this.$vux.confirm.show({
                    title: '设置到宿？',
                    content: `确定${student.student_name}(${student.student_num})同学到达宿舍后设置`,
                    onConfirm () {
                        _this.$http.post(`students/${student.id}/set_arrive_dorm`).then(res => {
                            _this.notArriveDormStudents.splice(index, 1);
                            _this.$vux.toast.show({
                                text: '设置到宿成功'
                            })
                        });
                    }
                });
            },
            ajaxRefreshStart () {
                this.timer = setInterval(() => {
                    this.$http.get('not_arrive_dorm_students', {
                        NoNProgress: true
                    }).then(res => {
                        this.notArriveDormStudents = res.data.data;
                        this.originalNotArriveDormStudents = [...res.data.data];
                    })
                }, 3000)
            }
        },
        data () {
            return {
                notArriveDormStudents: [],
                originalNotArriveDormStudents: [],
                keyword: ''
            }
        },
        beforeDestroy () {
            if(this.timer)
                clearInterval(this.timer);
        },
        mounted () {
            this.$http.get('not_arrive_dorm_students').then(res => {
                this.notArriveDormStudents = res.data.data;
                this.originalNotArriveDormStudents = [...res.data.data];
            })
            this.ajaxRefreshStart();
        }
    }
</script>

<style lang="less" scoped>

</style>