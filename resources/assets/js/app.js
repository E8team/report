import './bootstrap'
import App from './App.vue';
Vue.prototype.$axios = axios;
import router from './router'
const app = new Vue({
    router,
    ...App
}).$mount('#app');
