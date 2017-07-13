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
            name: 'check_info',
            component: require('./views/CheckInfo.vue')
        },
        {
            path: '/report_ok',
            component: require('./views/ReportOk.vue')
        },
        {
            path: '/select_dorm',
            name: 'select_dorm',
            component: require('./views/SelectDorm.vue')
        },
        {
            path: '/dorm/:id',
            name: 'dorm',
            component: require('./views/Dorm.vue')
        },
        {
            path: '/final',
            name: 'final',
            component: require('./views/Final.vue')
        },
        {
            path: '/feed_back',
            name: 'feed_back',
            component: require('../../common/views/Feedback.vue')
        },
        {
            path: '*',
            redirect: '/index'
        }
    ]
})

