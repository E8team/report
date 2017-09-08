<template>
    <div>
        <div v-if="isSuperAdmin" class="drop_down" @click="showPopup = true">
            <img slot="icon" src="../images/set.png">
        </div>
        <router-view></router-view>
        <tabbar class="tabbar" v-if="!$route.meta.noAuth">
            <tabbar-item link="/admin/index">
                <img slot="icon" src="../images/all.png">
                <span slot="label">总览</span>
            </tabbar-item>
            <tabbar-item link="/admin/detail">
                <img slot="icon" src="../images/set.png">
                <span slot="label">管理(机动)</span>
            </tabbar-item>
            <tabbar-item link="/admin/set_arrive_dorm">
                <img slot="icon" src="../images/form.png">
                <span slot="label">设置到宿(党站)</span>
            </tabbar-item>
            <tabbar-item link="/admin/feed_back">
                <img slot="icon" src="../images/edit.png">
                <span slot="label">反馈</span>
            </tabbar-item>
        </tabbar>
        <popup v-model="showPopup">
          <group title="请选择学院管理">
            <radio :options="allDepartments" @input="updateDepartmentId" v-model="departmentId"></radio>
          </group>
        </popup>
    </div>
</template>

<script>
    import { Tabbar, TabbarItem, Popup, Group, Radio } from 'vux'
    import { mapState, mapMutations } from 'vuex'

    export default{
        components: {
            Tabbar, TabbarItem, Popup, Group, Radio
        },
        computed: {
            ...mapState({
                departmentId: state => state.departmentId
            })
        },
        methods: {
            ...mapMutations({
                updateDepartmentId: 'UPDATE_DEPARTMENT_ID'
            })
        },
        data () {
            return {
                showPopup: false,
                isSuperAdmin: false,
                allDepartments: []
            }
        },
        watch: {
            departmentId () {
                setTimeout(() => {
                    this.showPopup = false;
                }, 100)
            }
        },
        mounted () {
            if(!this.$route.meta.noAuth){
                this.$http.get('me').then(res => {
                    this.isSuperAdmin = res.data.data.is_super_admin;
                    if(this.isSuperAdmin){
                        this.updateDepartmentId(res.data.data.department_id);
                        this.$http.get('all_departments').then(res => {
                            this.allDepartments = res.data.data.map(item => {
                                return {
                                    key: item.id,
                                    value: item.title
                                }
                            })
                        })
                    }
                });
            }
        }
    }
</script>

<style lang="less">
    @import '~vux/src/styles/reset.less';
    html,body{
        background-color: #FBF9FE;
    }
    body{
        padding-bottom: 60px;
    }
    *{
        box-sizing: border-box;
    }
    ul, li{
        list-style: none;
    }
    .tabbar{
        position: fixed!important;
    }
    .drop_down{
        opacity: .4;
        position: fixed;
        bottom: 80px;
        right: 20px;
        height: 50px;
        width: 50px;
        background-color: #fff;
        text-align: center;
        border: 1px solid #e1e1e1;
        border-radius: 10px;
        z-index: 999;
        &:active{
            background-color: #f5f5f5;
        }
        >img{
            width: 30px;
            height: 30px;
            margin-top: 9px;
        }
    }
    .vux-pop-out-enter-active,
    .vux-pop-out-leave-active,
    .vux-pop-in-enter-active,
    .vux-pop-in-leave-active {
        will-change: transform;
        transition: all 500ms;
        height: 100%;
        position: absolute;
        backface-visibility: hidden;
        perspective: 1000;
    }
    .vux-pop-out-enter {
        opacity: 0;
        transform: translate3d(-100%, 0, 0);
    }
    .vux-pop-out-leave-active {
        opacity: 0;
        transform: translate3d(100%, 0, 0);
    }
    .vux-pop-in-enter {
        opacity: 0;
        transform: translate3d(100%, 0, 0);
    }
    .vux-pop-in-leave-active {
        opacity: 0;
        transform: translate3d(-100%, 0, 0);
    }
    .router-view {
        width: 100%;
    }
</style>
