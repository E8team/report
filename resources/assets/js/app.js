import './bootstrap'
import App from './App.vue';
Vue.prototype.$http = axios.create({
    baseURL: '/api/',
    timeout: 5000,
    responseType: 'json',
    headers:{
        'X-CSRF-TOKEN': window.t_meta.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
    }
})
import TNav from './components/TNav.vue'
Vue.component(TNav.name, TNav)

import { AlertPlugin, ToastPlugin, ConfirmPlugin } from 'vux'

Vue.use(ConfirmPlugin)
Vue.use(AlertPlugin)
Vue.use(ToastPlugin)

const FastClick = require('fastclick')
FastClick.attach(document.body)

import router from './router'
const app = new Vue({
    router,
    ...App
}).$mount('#app');
