<template>
    <div>
        <t-nav title="选择宿舍" bgcolor="#f5f5f5" :show-back="false"></t-nav>
        <crumb :nav-list="navList"></crumb>
        <div class="dorm_list_wrapper"  v-for="dormList in dorms">
            <header>{{dormList.name}}</header>
            <ul class="dorm_list">
                <li v-for="dorm in dormList.list">
                    <div>{{dorm.galleryful}}人间</div>
                    {{dorm.dorm_num}}
                    <span class="surplus">剩余：{{dorm.galleryful_in_this_class - dorm.already_checked_in_num}}/{{dorm.galleryful_in_this_class}}</span>
                </li>
            </ul>
        </div>
    </div>
</template>


<script>
    import Crumb from '../components/Crumb.vue'
    export default{
        name: 'SelectDorm',
        components: {
            Crumb
        },
        mounted () {
            this.$http.get('dormitories/list').then(res => {
                const _this = this;
                res.data.data.map((item, index) => {
                    let key = item.dorm_unit + item.dorm_ridgepole;
                    if(!_this.dorms.hasOwnProperty(key)){
                        _this.dorms[key] = {
                            name: `${item.dorm_unit}单元${item.dorm_ridgepole}栋`,
                            list: []
                        };
                    }
                    _this.dorms[key].list.push(item);
                    this.$forceUpdate()
                })
            })
        },
        data () {
            return {
                navList: [
                    {
                        title: '选择宿舍',
                        href: '/select_dorm'
                    }
                ],
                dorms: {}
            }
        }
    }
</script>

<style lang="less" scoped>
    .dorm_list_wrapper{
        margin-top: 15px;
        background-color: #fff;
        >header{
            margin: 0 10px;
            padding-left: 5px;
            line-height: 35px;
            font-size: 14px;
            border-bottom: 1px solid #F5F5F5;
        }
        >.dorm_list{
            overflow: hidden;
            li{
                width: 50%;
                line-height: 80px;
                text-align: center;
                float: left;
                color: #333;
                border-bottom: 1px solid #F5F5F5;
                position: relative;
                >div{
                    position: absolute;
                    top: 5px;
                    left: 0;
                    background-color: #FB503B;
                    color: #fff;
                    font-size: 12px;
                    line-height: normal;
                    padding: 2px 3px;
                }
                >.surplus{
                    position: absolute;
                    bottom: 5px;
                    right: 5px;
                    font-size: 12px;
                    color: #999;
                    line-height: normal;
                }
                &:nth-child(odd){
                    border-right: 1px solid #f5f5f5;
                }
                &:active{
                    background-color: #f5f5f5;
                }
            }
        }
    }
</style>