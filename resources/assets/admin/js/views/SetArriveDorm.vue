<template>
    <div>
        <search @on-change="change" @on-cancel="onCancel" @on-focus="onFocus" v-model="keyword" :auto-fixed="false" placeholder="可按姓名，学号，拼音搜索"></search>
        <group>
            <cell @click.native="setArrive(item, index)" is-link :key="item.id" v-for="(item, index) in notArriveDormStudents" :title="item.student_name + '(' +item.student_num + ')'">{{item.dormitory.data.dorm_num}}</cell>
        </group>
        <p class="info" v-if="notArriveDormStudents.length == 0">当前没有学生报到</p>
        <x-dialog v-model="showConfirmDialog" class="dialog" hide-on-blur>
            <div class="img-box">
                <header>设置到宿</header>
                <ul>
                    <li @click="setArriveDorm(n, $event.target)" :class="{'disabled': !availableBedNum.available_bed_num.some(item => item == n)}" class="key" v-for="n in availableBedNum.galleryful" :key="n">{{n}}</li>
                </ul>
                <p class="tip">
                    设置 {{currstudent.student_name}} 选择的床位
                </p>
            </div>
            <div @click="showConfirmDialog=false">
                <span class="vux-close"></span>
            </div>
        </x-dialog>
        <actionsheet v-model="showConfirm" :menus="menus" show-cancel @on-click-menu="confirm">
            <div slot="header">
                <span>确认吗？</span>
                <p style="font-size: 14px; color: #777;">确认要将该新生的床铺设置为{{bedNum}}床号吗？</p>`
            </div>
        </actionsheet>
    </div>
</template>

<script>
    import { Group, Cell, Search, XDialog, Actionsheet } from 'vux';
    import { mapState } from 'vuex';
    export default{
        components: {
            Group, Cell, Search, XDialog, Actionsheet
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
            confirm (menu) {
                if(menu !== 'confirm'){
                    return ;
                }
                this.$http.post(`students/${this.currstudent.id}/set_arrive_dorm`, {
                    bed_num: this.bedNum
                }).then(res => {
                    this.notArriveDormStudents.splice(this.currindex, 1);
                    this.$vux.toast.show({
                        text: '设置到宿成功'
                    })
                    this.showConfirmDialog = false;
                });
            },
            setArriveDorm (bedNum, dom) {
                if(dom.className.indexOf('disabled') !== -1){
                    return;
                }
                this.bedNum = bedNum;
                this.showConfirm = true;
                this.showConfirmDialog = false;
            },
            setArrive (student, index) {
                this.$http.get(`students/${student.id}/available_bed_num`).then(res => {
                    this.availableBedNum = res.data;
                })
                this.showConfirmDialog = true;
                this.currstudent = student;
                this.currindex = index;
            },
            ajaxRefreshStart () {
                this.timer = setInterval(() => {
                    this.$http.get(`not_arrive_dorm_students/${this.departmentId}`, {
                        NoNProgress: true,
                        params: {
                            include: 'dormitory'
                        }
                    }).then(res => {
                        this.notArriveDormStudents = res.data.data;
                        this.originalNotArriveDormStudents = [...res.data.data];
                    })
                }, 20000)
            }
        },
        computed: {
            ...mapState({
                departmentId: state => state.departmentId
            })
        },
        data () {
            return {
                menus: {
                    confirm: '<span style="color:green">确认</span>'
                },
                bedNum: 0,
                showConfirm: false,
                notArriveDormStudents: [],
                originalNotArriveDormStudents: [],
                keyword: '',
                showConfirmDialog: false,
                currstudent: {},
                currIndex: null,
                availableBedNum: {}
            }
        },
        beforeDestroy () {
            if(this.timer)
                clearInterval(this.timer);
        },
        mounted () {
            this.$http.get(`not_arrive_dorm_students/${this.departmentId}`, {
                params: {
                    include: 'dormitory'
                }
            }).then(res => {
                this.notArriveDormStudents = res.data.data;
                this.originalNotArriveDormStudents = [...res.data.data];
            })
            this.ajaxRefreshStart();
        }
    }
</script>

<style lang="less">
.info{
    font-size: 14px;
    color: #666;
    text-align: center;
}
@import '~vux/src/styles/close';
.dialog {
  .weui-dialog{
    border-radius: 8px;
    padding-bottom: 8px;
  }
  .dialog-title {
    line-height: 30px;
    color: #666;
  }
  .img-box {
    height: 300px;
    overflow: hidden;
    >header{
        line-height: 45px;
        color: #666;
    }
    >ul{
        padding: 20px;
        overflow: hidden;
        .key{
            width: 50%;
            line-height: 60px;
            border: 1px solid #eee;
            float: left;
            &:active{
                background-color: #f5f5f5;
            }
            &.disabled{
                background-color: #f5f5f5;
            }
        }
    }
    .tip{
        font-size: 12px;
        color: #999;
    }
  }
  .vux-close {
    margin-top: 8px;
    margin-bottom: 8px;
  }
}
</style>
