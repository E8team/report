window.Vue = require('vue');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import App from './App.vue';
import nprogress from 'nprogress';
import 'nprogress/nprogress.css'
import { AlertPlugin, ToastPlugin, ConfirmPlugin } from 'vux'

Vue.use(ConfirmPlugin)
Vue.use(AlertPlugin)
Vue.use(ToastPlugin)

Vue.prototype.$http = axios.create({
    baseURL: '/api/admin/',
    timeout: 5000,
    responseType: 'json',
    headers:{
        'X-CSRF-TOKEN': window.t_meta.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
    }
})
Vue.prototype.$http.interceptors.request.use((config) => {
    if(!config.NoNProgress){
        nprogress.start();
    }
    return config;
}, (error) => {
    nprogress.done();
    return Promise.reject(error);
});
Vue.prototype.$http.interceptors.response.use((response) => {
    nprogress.done();
    return response;
}, (error) => {
    nprogress.done();
    if(error.code === 'ECONNABORTED'){
        Vue.$vux.toast.show({
            text: '请求超时',
            type: 'warn'
        })
    }else if(error.response.status === 401 && error.response.data.code == '401.1'){
        Vue.$vux.toast.show({
            text: '请先登录',
            position: 'top',
            type: 'text'
        })
        router.push({name: 'login'});
    }else {
        if(error.config.noErrorTip){
            return Promise.reject(error);
        }
        if(error.response.data.message){
            Vue.$vux.toast.show({
                text: error.response.data.message,
                type: 'warn'
            })
        }
    }
    return Promise.reject(error);
});
const FastClick = require('fastclick')
FastClick.attach(document.body)
import router from './router'
import store from './vuex/store'
const app = new Vue({
    store,
    router,
    ...App
}).$mount('#app');