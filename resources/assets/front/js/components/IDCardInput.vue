<template>
    <popup style="background-color: #f7f7f7;" v-model="show">
        <div class="identity_input_container">
            <header>
                <h3>输入身份证后4位</h3>
                <span v-if="identityError.show" class="error">{{identityError.msg}}</span>
                <div @click="show = false" class="close_btn">x</div>
            </header>
            <div class="res_container">
                <flexbox class="res">
                    <template v-for="n in identityDigit">
                        <flexbox-item><div class="item">{{identityNums[n - 1]}}</div></flexbox-item>
                    </template>
                </flexbox>
            </div>
            <div class="keyboard_container">
                <ul>
                    <li>1</li><li>2</li><li>3</li>
                    <li>4</li><li>5</li><li>6</li>
                    <li>7</li><li>8</li><li>9</li>
                    <li id="num_x" class="disabled">x</li><li>0</li><li class="back_space" @click="delIdentity()"><i class="iconfont icon-backspace"></i></li>
                </ul>
            </div>
        </div>
    </popup>
</template>


<script>
    import { Popup, Flexbox, FlexboxItem } from 'vux'
    export default{
        name: 'IDCardInput',
        components: {
            Popup, Flexbox, FlexboxItem
        },
        props: {
            value: Boolean
        },
        data () {
            return {
                show: false,
                identityDigit: 4,
                identityError: {
                    show: false,
                    msg: ''
                },
                identityNums: []
            }
        },
        watch: {
            value (val) {
                this.show = val
                this.identityNums = []
            },
            show (val, oldVal) {
                if(val !== oldVal){
                    this.$emit('input', val)
                }
            }
        },
        methods: {
            error (msg, time = 2000) {
                this.identityError = {
                    show: true,
                    msg
                }
                setTimeout(() => {
                    this.identityError.show = false;
                }, time)
            },
            inputIdentity (number) {
                if (this.identityNums.length < this.identityDigit) {
                    this.identityNums.push(number)
                    if (this.identityNums.length === this.identityDigit - 1) {
                        this.$el.querySelector('#num_x').className = ''
                    }
                    if (this.identityNums.length === this.identityDigit) {
                        // 清空身份证输入框
                        let pwd = this.identityNums.join('')
                        this.$el.querySelector('#num_x').className = 'disabled'
                        this.$emit('pwd', pwd)
                        setTimeout(() => {
                            this.identityNums = []
                        }, 300)
                    }
                }
            },
            delIdentity () {
                this.identityNums.pop()
                if (this.identityNums.length < this.identityDigit - 1) {
                    this.$el.querySelector('#num_x').className = 'disabled'
                }
            }
        },
        mounted () {
            let lis = this.$el.querySelectorAll('.keyboard_container>ul>li:not(.back_space)')
            let self = this
            for (let liIndex in lis) {
                if (liIndex !== 'length') {
                    lis[liIndex].onclick = function () {
                        if (this.className === 'disabled') {
                            return false
                        }
                        self.inputIdentity(this.innerHTML)
                    }
                }
            }
        }
    }
</script>

<style lang="less" scoped>
    .identity_input_container {
        > header {
            position: relative;
            border-bottom: 1px solid #ededed;
            > h3 {
                font-weight: 100;
                text-align: center;
                margin: 14px 0;
            }
            > .error {
                color: #f30;
                text-align: center;
                display: block;
                font-size: 13px;
                position: relative;
                top: -10px;
            }
            > .close_btn {
                position: absolute;
                left: 14px;
                top: 2px;
                padding: 2px 12px;
                &:active {
                    background-color: #e1e1e1;
                }
            }
        }
        > .res_container {
            padding: 0 20px;
            > .res {
                height: 60px;
                border: 1px #ccc solid;
                border-radius: 5px;
                margin: 20px 0;
                > .vux-flexbox-item {
                    height: 100%;
                    line-height: 60px;
                    margin-left: 0 !important;
                    &:not(:last-child) {
                        border-right: 1px #e1e1e1 solid;
                    }
                    > .item {
                        font-size: 24px;
                        font-weight: bold;
                        text-align: center;
                    }
                }
            }
        }
        > .keyboard_container {
            margin-top: 30px;
            > ul {
                background-color: #fff;
                overflow: hidden;
                > li {
                    float: left;
                    width: 33.333333%;
                    text-align: center;
                    border-right: 1px #eee solid;
                    border-bottom: 1px #eee solid;
                    line-height: 2.3;
                    font-size: 24px;
                    &.disabled {
                        background-color: #f1f1f1;
                        color: #aaa;
                    }
                    &:active:not(.disabled) {
                        background-color: #f1f1f1;
                    }
                    &.back_space {
                        background-color: #ddd;
                        color: #fff;
                        &:active {
                            color: #333;
                        }
                        > i {
                            line-height: normal;
                            font-size: 26px;
                        }
                    }
                }
            }
        }
    }
</style>