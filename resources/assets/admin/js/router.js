import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    mode: 'history',
    base: __dirname,
    routes: [
        {
            path: '/admin/index',
            name: 'index',
            component: require('./views/Index.vue')
        },
        {
            path: '/admin/login',
            name: 'login',
            meta: {
                noAuth: true
            },
            component: require('./views/Login.vue')
        },
        {
            path: '/admin/detail',
            name: 'detail',
            component: require('./views/Detail.vue')
        },
        {
            path: '/admin/set_arrive_dorm',
            name: 'set_arrive_dorm',
            component: require('./views/SetArriveDorm.vue')
        },
        {
            path: '/admin/feed_back',
            name: 'feed_back',
            component: require('../../common/views/Feedback.vue')
        },
        {
            path: '/admin/register',
            name: 'register',
            meta: {
                noAuth: true
            },
            component: require('./views/Register.vue')
        },
        ,
        {
            path: '/admin/register_ok',
            name: 'registerOk',
            meta: {
                noAuth: true
            },
            component: require('./views/RegisterOk.vue')
        },
        {
            path: '*',
            redirect: '/admin/index'
        }
    ]
})

