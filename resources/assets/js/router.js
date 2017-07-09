import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);


export default new Router({
    mode: 'history',
    base: __dirname,
    routes: [
        {
            path: '/index',
            component: require('./views/Index.vue')
        },
        {
            path: '/check_info',
            component: require('./views/CheckInfo.vue')
        },
        {
            path: '*',
            redirect: '/index'
        }
    ]
})

