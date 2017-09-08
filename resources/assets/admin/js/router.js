import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);
const Parent = {
    data () {
      return {
        transitionName: ''
      }
    },
    beforeRouteUpdate (to, from, next) {
      const toDepth = to.path.split('/').length
      const fromDepth = from.path.split('/').length
      this.transitionName = toDepth < fromDepth ? 'vux-pop-out' : 'vux-pop-in'
      next()
    },
    template: `
    <transition :name="transitionName">
        <router-view class="router-view"></router-view>
    </transition>
    `
  }
export default new Router({
    mode: 'history',
    base: __dirname,
    routes: [
        {
            path: '/admin/index',
            component: Parent,
            children: [
                {
                    path: '',
                    name: 'index',
                    component: require('./views/Index.vue'),
                },
                {
                    path: 'class_detail/:id',
                    name: 'class_detail',
                    component: require('./views/ClassDetail.vue')
                }
            ]
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
        /*{
            path: '/admin/register',
            name: 'register',
            meta: {
                noAuth: true
            },
            component: require('./views/Register.vue')
        },
        {
            path: '/admin/register_ok',
            name: 'register_ok',
            meta: {
                noAuth: true
            },
            component: require('./views/RegisterOk.vue')
        },*/
        {
            path: '*',
            redirect: '/admin/index'
        }
    ]
})

