import './bootstrap'
import App from './App.vue';
import NProgress from 'NProgress';
import 'NProgress/nprogress.css'

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
Vue.prototype.$http.interceptors.request.use((config) => {
    if(!config.NoNProgress){
        NProgress.start();
    }
    return config;
}, (error) => {
    nprogress.done();
    return Promise.reject(error);
});
Vue.prototype.$http.interceptors.response.use((response) => {
    NProgress.done();
    return response;
}, (error) => {
    NProgress.done();
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
        router.push({name: 'index'});
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
import TNav from '../../common/components/TNav.vue'
Vue.component(TNav.name, TNav)


const FastClick = require('fastclick')
FastClick.attach(document.body)

import router from './router'

import store from './vuex/store'

// simple history management
const history = window.sessionStorage
history.clear()
let historyCount = history.getItem('count') * 1 || 0
history.setItem('/', 0)
router.beforeEach(function (to, from, next) {

    const toIndex = history.getItem(to.path)
    const fromIndex = history.getItem(from.path)

    if (toIndex) {
        if (!fromIndex || parseInt(toIndex, 10) > parseInt(fromIndex, 10) || (toIndex === '0' && fromIndex === '0')) {
            store.commit('UPDATE_DIRECTION', {direction: 'forward'})
        } else {
            store.commit('UPDATE_DIRECTION', {direction: 'reverse'})
        }
    } else {
        ++historyCount
        history.setItem('count', historyCount)
        to.path !== '/' && history.setItem(to.path, historyCount)
        store.commit('UPDATE_DIRECTION', {direction: 'forward'})
    }

    if (/\/http/.test(to.path)) {
        let url = to.path.split('http')[1]
        window.location.href = `http${url}`
    } else {
        next()
    }
})


const app = new Vue({
    store,
    router,
    ...App
}).$mount('#app');
