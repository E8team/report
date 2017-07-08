<template>
    <div>
        <div class="logo">
            <img src="../../images/logo.png" alt="">
            <p class="title">2017新生自助报到</p>
        </div>
        <div class="input_box">
            <div class="placeholder">支持简拼搜索 如:小明(xm)</div>
            <div class="input_container">
                <input @click.stop type="text"  v-model="studentName"  class="student_input" placeholder="请输入你的姓名">
                <button @click.stop="login" class="login_button">确认</button>
            </div>
            <div class="tip">
                <ul>
                    <li @click.stop="selStudentName(item)" v-for="item in matchList"><button>{{item}}</button></li>
                </ul>
            </div>
        </div>
        <IDCardInput v-model="showIDCardInput"></IDCardInput>
    </div>
</template>


<script>
    import IDCardInput from '../components/IDCardInput.vue'
    export default{
        name: 'index',
        components: {
            IDCardInput
        },
        mounted () {
        },
        data () {
            return {
                studentName: '',
                matchList: [],
                showIDCardInput: false
            }
        }
    }
</script>

<style lang="less" scoped>
    .logo{
        width: 70%;
        max-width: 300px;
        margin: 30px auto;
        img{
            width: 100%;
        }
        >p{
            font-size: 12px;
            text-align: center;
            margin-top: 10px;
            color: #aaa;
            &.title{
                font-size: 14px;
            }
        }
    }
    .input_box {
        padding: 20px;
        margin-top: 15px;
        > .placeholder {
            color: #666;
            font-size: 12px;
            padding: 3px 6px;
        }
        > .tip {
            border-top: 0;
            border-radius: 0 0 2px 2px;
            background: #FFF;
            -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            margin: 1px;
            margin-top: 0;
            z-index: 2;
            position: relative;
            > ul {
                font-size: 16px;
                line-height: 15px;
                text-align: left;
                color: #333;
                > li {
                    padding-left: 10px;
                    transition: background-color .3s;
                    > button {
                        width: 100%;
                        display: block;
                        text-align: left;
                        font-size: 14px;
                        line-height: 28px;
                        color: #555;
                    }
                    &:active {
                        background-color: #eef3fe;
                    }
                }
            }
        }
        > .input_container {
            position: relative;
            > .student_input {
                outline: none;
                background-color: #fff;
                height: 44px;
                width: 100%;
                border-radius: 2px 0 0 2px;
                padding: 0 10px;
                padding-right: 76px;
                border: 1px solid #eee;
                outline: 0;
                transition: border-color .3s, box-shadow .3s;
                font-size: 15px;
                color: #333;
                &:focus {
                    border: 1px solid #82c3fe;
                    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.1);
                }
                &.error {
                    border-color: #f30;
                }
            }
            .login_button{
                position: absolute;
                right: 2px;
                top: 2px;
                height: 40px;
                width: 66px;
                background: #fbfbfb;
                color: #666;
                font-size: .75rem;
                white-space: nowrap;
                letter-spacing: -1px;
                box-sizing: inherit;
                border:none;
            }
        }
    }
</style>