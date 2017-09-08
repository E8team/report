<template>
    <div>
        <search
            @result-click="resultClick"
            @on-change="getResult"
            @on-cancel="onCancel"
            v-model="keyword"
            :results="results"
            position="absolute"
            auto-scroll-to-top
            placeholder="可按姓名，学号，拼音搜索"
            @on-focus="onFocus"
            ref="search">
        </search>
        <div class="tip" v-if="Object.getOwnPropertyNames(studentInfo).length <= 1">
            输入学生姓名或学号以修改
        </div>
        <template v-else>
            <group>
                <cell title="学号" :value="studentInfo.student_num"></cell>
                <cell title="姓名" :value="studentInfo.student_name"></cell>
                <cell title="班级" :value="studentInfo.department_class"></cell>
                <cell title="性别" :value="studentInfo.gender_str"></cell>
                <cell title="身份证" :value="studentInfo.id_card"></cell>
                <x-switch ref="isAllowReportSwitch" title="允许报到" v-model="allowReport"></x-switch>
                <x-switch ref="isReportSwitch" v-if="allowReport" title="是否报到" v-model="isReport"></x-switch>
                <cell title="报到时间" v-if="isReport && allowReport" :value="studentInfo.report_at"></cell>
                <cell title="到宿时间" v-if="isReport && allowReport" :value="studentInfo.arrive_dorm_at != null ? studentInfo.arrive_dorm_at : '尚未到宿'"></cell>
                <cell title="所选床位" v-if="studentInfo.dormitory.data.bed_num" :value="studentInfo.dormitory.data.bed_num + '号铺'"></cell>
            </group>
            <box gap="10px" v-if="isReport && allowReport">
                <load-more style="margin-bottom: 10px;" tip="可选宿舍" :show-loading="false" background-color="#fbf9fe"></load-more>
                <checker
                    v-model="selectedDormId"
                    default-item-class="dorm_select_item"
                    selected-item-class="dorm_select_item_selected"
                    class="checker"
                >
                    <div class="dorm_select_item_wrapper" :key="dorm.id" v-for="dorm in availableDormitories">
                        <checker-item :value="dorm.id">
                            <div class="dorm_item">
                                <div :class="{four: dorm.galleryful == 4}">{{dorm.galleryful}}人间</div>
                                {{dorm.dorm_num}}
                                <span class="surplus">剩余：{{dorm.galleryful_in_this_class - dorm.already_selected_num_in_this_class}}/{{dorm.galleryful_in_this_class}}</span>
                            </div>
                        </checker-item>
                    </div>
                </checker>
            </box>
        </template>
        <popup v-model="showReportInfoPopup" height="60%">
            <div>
                <group title="请一定注意身高的单位是厘米,体重的单位是斤！！！">
                    <x-input required title="身高(cm):" type="number" v-model.number="height"></x-input>
                    <x-input required title="体重(斤):" type="number" v-model.number="weight"></x-input>
                </group>
                <box gap="20px 10px">
                    <x-button type="primary" @click.native="setReport">设置报到</x-button>
                </box>
            </div>
        </popup>
    </div>
</template>

<script>
    import { Search, Group, Cell, XSwitch, Checker, CheckerItem, Box, LoadMore, dateFormat,  Popup, XInput, XButton  } from 'vux'
    export default {
        components: {
            Search, Group, Cell, XSwitch, Checker, CheckerItem, Box, LoadMore, Popup, XInput, XButton
        },
        data () {
            return {
                isFirst: true,
                results: [],
                keyword: '',
                studentInfo: {},
                selectedDormId: null,
                availableDormitories: [],
                isReportCancel: false,
                isAllowReportCancel: false,
                showReportInfoPopup: false,
                height: null,
                weight: null,
                currentStudentVal: null
            }
        },
        watch: {
            selectedDormId () {
                if (!this.isFirst) {
                    if(this.selectedDormId == null){
                        return;
                    }
                    this.$http.post(`students/${this.studentInfo.id}/cancel_dorm`).then(res => {
                        if(this.selectedDormId){
                            this.$http.post(`students/${this.studentInfo.id}/select_dorm/${this.selectedDormId}`).then(res => {
                                this.$vux.toast.show({
                                    text: '选择宿舍成功'
                                })
                                this.getAvailableDormitories(this.studentInfo.id);
                            }).catch(err => {
                                if(err.response.status === 401){
                                    this.refresh();
                                }
                            });
                            return;
                        }else {
                            this.getAvailableDormitories(this.studentInfo.id);
                            this.$vux.toast.show({
                                text: '已取消选择宿舍',
                                position: 'top',
                                type: 'text'
                            })
                            this.selectedDormId = null;
                        }
                    }).catch(err => {
                        if(err.response.status === 401){
                            this.refresh();
                        }
                    })
                }else{
                    this.isFirst = false;
                }
            },
            showReportInfoPopup (curVal) {
                if(!curVal){
                    if(this.currentStudentVal){
                        this.refresh();
                    }
                }
            }
        },
        computed: {
            allowReport: {
                get () {
                    return this.studentInfo.allow_report_at != null
                },
                set (newValue) {
                    if(this.isAllowReportCancel){
                        this.isAllowReportCancel = false;
                        return;
                    }
                    if(newValue){
                        this.$http.post(`students/${this.studentInfo.id}/allow_report`).then(res => {
                            this.$vux.toast.show({
                                text: '已允许报到'
                            })
                            this.studentInfo.allow_report_at = dateFormat(new Date(), 'YYYY-MM-DD HH:mm:ss');
                        }).catch(err => {
                            if(err.response.status === 401){
                                this.refresh();
                            }
                        });
                    }else{
                        const _this = this
                        this.studentInfo.allow_report_at_bak = this.studentInfo.allow_report_at;
                        this.studentInfo.allow_report_at = null;
                        if(_this.selectedDormId != null){
                            this.$vux.confirm.show({
                                title: '取消允许报到？',
                                content: `取消允许报到后，该同学选择的宿舍也将取消，是否取消允许报到？`,
                                onConfirm () {
                                    _this.$http.post(`students/${_this.studentInfo.id}/cancel_allow_report`).then(res => {
                                        _this.$vux.toast.show({
                                            text: '已取消允许报到'
                                        });
                                        _this.studentInfo.allow_report_at = null;
                                        _this.isFirst = true;
                                        _this.selectedDormId = null;
                                        _this.studentInfo.report_at = null;
                                    }).catch(e => {
                                        _this.studentInfo.allow_report_at = _this.studentInfo.allow_report_at_bak;
                                        if(e.response.status === 401){
                                            _this.refresh();
                                        }
                                    })
                                },
                                onCancel () {
                                    _this.$refs['isAllowReportSwitch'].currentValue = true;
                                    _this.isAllowReportCancel = true;
                                    _this.studentInfo.allow_report_at = _this.studentInfo.allow_report_at_bak;
                                }
                            })
                        }else{
                            _this.$http.post(`students/${_this.studentInfo.id}/cancel_allow_report`).then(res => {
                                _this.$vux.toast.show({
                                    text: '已取消允许报到'
                                })
                                _this.studentInfo.report_at = null;
                                _this.studentInfo.allow_report_at = null;
                            }).catch(e => {
                                _this.studentInfo.allow_report_at = _this.studentInfo.allow_report_at_bak;
                                if(e.response.status === 401){
                                    _this.refresh();
                                }
                            })
                        }

                    }
                }
            },
            setReport () {
                if (!this.height) {
                    Vue.$vux.toast.show({
                        text: '请填写身高!',
                        type: 'warn'
                    })
                    return;
                }
                if (!this.weight) {
                    Vue.$vux.toast.show({
                        text: '请填写体重!',
                        type: 'warn'
                    })
                    return;
                }
                this.$http.post(`students/${this.studentInfo.id}/set_report`, {
                    height: this.height,
                    weight: this.weight
                }).then(res => {
                    this.$vux.toast.show({
                        text: '设置报到成功',
                    })
                    this.studentInfo.report_at = dateFormat(new Date(), 'YYYY-MM-DD HH:mm:ss');
                    this.getAvailableDormitories(this.studentInfo.id);
                    this.showReportInfoPopup = false;
                    this.height =  null;
                    this.weight =  null;
                }).catch(err => {
                    if (err.response.status === 422) {
                        const errors = err.response.data.errors;
                        let messageText = '';
                        for(let index in errors){
                            messageText += (errors[index] + '<br/>');
                        }
                        this.$vux.alert.show({
                            title: '输入有误',
                            content: messageText
                        })
                    }
                    if(err.response.status === 401){
                        this.refresh();
                    }
                });
            },
            isReport: {
                get () {
                    return this.studentInfo.report_at != null
                },
                set (newValue) {
                    if(this.isReportCancel){
                        this.isReportCancel = false;
                        return;
                    }
                    if(newValue){
                        this.showReportInfoPopup = true;
                    }else{
                        const _this = this
                        if(_this.selectedDormId != null) {
                            this.$vux.confirm.show({
                                title: '取消报到？',
                                content: `取消报到后，该同学选择的宿舍也将取消，是否取消报到？`,
                                onConfirm () {
                                    _this.$http.post(`students/${_this.studentInfo.id}/cancel_report`).then(res => {
                                        _this.$vux.toast.show({
                                            text: '取消报到成功'
                                        })
                                        _this.studentInfo.report_at = null;
                                        _this.selectedDormId = null;
                                        _this.refresh();
                                    }).catch(err => {
                                        if(err.response.status === 401){
                                            _this.refresh();
                                        }
                                    });
                                },
                                onCancel () {
                                    _this.$refs['isReportSwitch'].currentValue = true;
                                    _this.isReportCancel = true;
                                }
                            });
                        }else{
                            _this.$http.post(`students/${_this.studentInfo.id}/cancel_report`).then(res => {
                                _this.$vux.toast.show({
                                    text: '取消报到成功'
                                })
                                _this.studentInfo.report_at = null;
                            }).catch(err => {
                                if(err.response.status === 401){
                                    _this.refresh();
                                }
                            });
                        }
                    }
                }
            }
        },
        methods: {
            refresh () {
                this.studentInfo = {};
                this.resultClick(this.currentStudentVal);
            },
            onCancel () {
                this.keyword = '';
                this.studentInfo = {};
            },
            onFocus () {
                this.keyword = '';
                this.studentInfo = {};
            },
            getAvailableDormitories (id) {
                this.$http.get(`students/${id}/available_dormitories`).then(res => {
                    this.availableDormitories = res.data.data;
                })
            },
            resultClick (val) {
                this.keyword = /\d/.test(this.keyword[0]) ? val.student_num : val.student_name;
                this.currentStudentVal = val;
                this.$http.get(`students/${val.id}?include=dormitory,student_profile`).then(res => {
                    this.studentInfo = res.data.data;
                    this.height = res.data.data.student_profile.data.height;
                    this.weight = res.data.data.student_profile.data.weight;
                    this.isFirst = true;
                    this.selectedDormId = this.studentInfo.dormitory.data.id;
                    if(this.studentInfo.report_at != null){
                        this.getAvailableDormitories(val.id);
                    }
                })
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
    .checker{
        overflow: hidden;
    }
    .dorm_select_item_wrapper{
        width: 33.33%;
        padding: 0 3px;
        float: left;
        overflow: hidden;
        .dorm_select_item{
            width: 100%;
            line-height: 26px;
            text-align: center;
            border-radius: 3px;
            border: 1px solid #ccc;
            background-color: #fff;
            &.dorm_select_item_selected {
                background: #ffffff url(../../images/selected.png) no-repeat right bottom;
                border-color: #ff4a00;
            }
            .dorm_item{
                width: 100%;
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
                    background-color: rgba(255,73,73,.1);
                    font-size: 12px;
                    line-height: normal;
                    padding: 2px 3px;
                    color: #ff4949;
                    &.four{
                        background-color: rgba(32,160,255,.1);
                        color: #20a0ff;
                    }
                }
                >.surplus{
                    position: absolute;
                    bottom: 5px;
                    right: 5px;
                    font-size: 12px;
                    color: #999;
                    line-height: normal;
                }
                &:active{
                    background-color: #f5f5f5;
                }
            }
        }
    }
</style>
