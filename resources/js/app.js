import Vue from 'vue'
import Index from './Index'
import router from './router'
import VueDragscroll from 'vue-dragscroll'

// require('./assets/sidebar');
require('./bootstrap');

Vue.use(VueDragscroll)

new Vue ({
    el: '#app',
    components: {
        Index
    },
    router
})
