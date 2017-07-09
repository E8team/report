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
import { AlertPlugin, ToastPlugin } from 'vux'

Vue.use(AlertPlugin)
Vue.use(ToastPlugin)
import router from './router'
const app = new Vue({
    router,
    ...App
}).$mount('#app');
