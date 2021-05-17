import Vue from 'vue'
import common from './common'
Vue.mixin(common)

require('./bootstrap');

window.Vue = require('vue')
Vue.component('search', require('./components/search.vue').default)
Vue.component('comment', require('./components/comment.vue').default)
Vue.component('writecomment', require('./components/writecomment.vue').default)
Vue.component('login', require('./components/login.vue').default)



const app = new Vue({
   el:'#app',

})