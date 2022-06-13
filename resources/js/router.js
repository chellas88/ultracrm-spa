import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/login', component: () => import('../Pages/Auth/Login'),
            name: 'login'
        },
        {
            path: '/', component: () => import('../Pages/Home'),
            name: 'home'
        },
        {
            path: '/pipeline', component: () => import('../Pages/Pipeline'),
            name: 'pipeline.index'
        },
        {
            path: '/tasks', component: () => import('../Pages/Tasks'),
            name: 'tasks'
        },
    ]
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('x_xsrf_token')
    if (!token){
        if (to.name === 'login'){
            return next()
        }
        else {
            return next({
                name: 'login'
            })
        }
    }
    else {
        if (to.name === 'login'){
            return next({
                name: 'home'
            })
        }
        return next()
    }

})

export default router
