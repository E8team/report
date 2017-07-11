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
import { AlertPlugin, ToastPlugin, ConfirmPlugin } from 'vux'

Vue.use(ConfirmPlugin)
Vue.use(AlertPlugin)
Vue.use(ToastPlugin)

Vue.prototype.$http = axios.create({
    baseURL: '/api/',
    timeout: 5000,
    responseType: 'json',
    headers:{
        'X-CSRF-TOKEN': window.t_meta.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
    }
})
const FastClick = require('fastclick')
FastClick.attach(document.body)
import router from './router'
const app = new Vue({
    router,
    ...App
}).$mount('#app');