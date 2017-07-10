import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);


export default new Router({
    mode: 'history',
    base: __dirname,
    routes: [
        {
            path: '/index',
            name: 'index',
            component: require('./views/Index.vue')
        },
        {
            path: '/check_info',
            component: require('./views/CheckInfo.vue')
        },
        {
            path: '/report_ok',
            component: require('./views/ReportOk.vue')
        },
        {
            path: '/select_dorm',
            component: require('./views/SelectDorm.vue')
        },
        {
            path: '/dorm/:id/:name?',
            name: 'dorm',
            component: require('./views/Dorm.vue')
        },
        {
            path: '*',
            redirect: '/index'
        }
    ]
})

