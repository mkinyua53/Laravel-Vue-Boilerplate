require('./bootstrap')
import Vue from 'vue'
import moment from 'moment'
import Vuetify from 'vuetify'
import swal from 'sweetalert'
import VueCookie from 'vue-cookie'
import Auth from './utils/auth/index'
import VueValidate from 'vee-validate'
import VueResource from 'vue-resource'
import VuePaginate from 'vue-paginate'
import store from './utils/store/index'
import VueAnalytics from 'vue-analytics'
import router from './utils/router/index'
import nprogress from './utils/NProgress'
import actions from './utils/mixins/actions'
import CKEditor from '@ckeditor/ckeditor5-vue'
import breakpoint from './utils/mixins/breakpoint'
import userActions from './utils/mixins/user_actions'
import messages from './utils/sockets/index'
import VueMeta from 'vue-meta'

Vue.use(Auth)
Vue.use(Vuetify)
Vue.use(CKEditor)
Vue.use(VueCookie)
Vue.use(VueValidate)
Vue.use(VueResource)
Vue.use(VuePaginate)

Vue.use(VueAnalytics, {
  id: 'UA-114111037-1',
  router
})

Vue.use(VueMeta, {
  keyName: 'metaInfo',
  attribute: 'data-vue-meta',
  ssrAttribute: 'data-vue-meta-server-rendered',
  tagIDKeyName: 'vmid',
  refreshOnceOnNavigation: true
})

Vue.mixin(userActions)
Vue.mixin(breakpoint)
Vue.mixin(actions)
Vue.mixin(messages)

Vue.prototype.moment = moment

var orig = window.location.origin + '/api'

if (orig.includes('3000')) {
  // orig = 'http://localhost:8000/api'
}
// var socketId = window.Echo ? window.Echo.socketId() : ''

  Vue.http.headers.common['X-CSRF-TOKEN'] = window.$('meta[name="csrf-token"]').attr('content')
  Vue.http.headers.common['X-Requested-With'] = 'XMLHttpRequest'
  // Vue.http.headers.common['X-SOCKET-ID'] = socketId
  Vue.http.options = { root: orig }

  Vue.http.interceptors.push((request, next) => {
    request.headers.set('Authorization','Bearer '+ Vue.auth.getToken())
    nprogress.start()

    next(response => {
      nprogress.done()

      switch(response.status) {
        case null:
        break
        case 401:
        Vue.auth.destroyToken()
        console.log('401 error')
        if (router.currentRoute.path == '/') {
          return
        }
        if (router.currentRoute.query.redirect) {
          swal.close()
        }
        else {
          router.push('/login?redirect='+router.currentRoute.fullPath)
        }
        break
        case 403:
        router.push('/unauthorized?path=' + router.currentRoute.fullPath)
        break
        case 302:
        swal('Warning!','The server recieved your request but could not handle it correctly. Please try again later.','warning')
        break
        case 310:
          Vue.auth.destroyToken()
          swal('Warning!','Account not activated','warning')
          router.push('/user-inactive?path=' + router.currentRoute.fullPath)
          break
        case 500:
          router.push('/server-error?path=' + router.currentRoute.fullPath)
          break
        default:
        break
      }
    })
  })

router.beforeEach((to, from, next) => {
  nprogress.start()
  if (to.matched.some(record => record.meta.forAuth)) {
    if (Vue.auth.isAuthenticated()) {
      if (Vue.auth.getUser()) {
        next()
      }
      else {
        store.cacheDispatch('user')
        .then(response => {
          next()
        })
        .catch(err => {
          Vue.auth.destroyToken()
          next({
            path: '/login',
            query: {
              redirect: to.fullPath
            }
          })
        })
      }
    }
    else {
      Vue.auth.destroyToken()
      next({
            path: '/login',
            query: { redirect: to.fullPath }
          })
    }
  }
  if (to.matched.some(record => record.meta.forGuest)) {
    if (Vue.auth.isAuthenticated()) {
      next({
        path: '/user',
      })
    }
    else {
      next()
    }
  }
  else{
    next()
  }
})

router.afterEach((to, from) => {
  // Complete the animation of the route progress bar.
  nprogress.done()
})

swal.setDefaults({
  html: true,
  allowOutsideClick: true
})

window.addEventListener("offline", function (e) {
  store.commit('offline', true)
}, false);

window.addEventListener("online", function (e) {
  store.commit('offline', false)
}, false);

// Get the mode
var dark = window.matchMedia('(prefers-color-scheme: dark)')
// if (dark.matches) {
//   document.cookie = "mode=theme--dark";
//   store.commit('mode', { mode: 'theme--dark' })
// }
var light = window.matchMedia('(prefers-color-scheme: light)')
// if (light.matches) {
//   document.cookie = "mode=theme--dark";
//   store.commit('mode', { mode: 'theme--dark' })
// }
dark.onchange = function () {
  checkDarkMode()
}
light.onchange = function () {
  checkDarkMode()
}
function checkDarkMode() {
  // console.log('Mode changed')
  var dark = window.matchMedia('(prefers-color-scheme: dark)')
  var light = window.matchMedia('(prefers-color-scheme: light)')
  if (dark.matches) {
    document.cookie = "mode=theme--dark";
    store.commit('mode', { mode: 'theme--dark' })
  }
  if(light.matches) {
    document.cookie = "mode=theme--light";
    store.commit('mode', { mode: 'theme--light' })
  }
  if (!light.matches && !dark.matches) {
    document.cookie = "mode=";
    store.commit('mode', { mode: '' })
  }
}

// components
Vue.component(
  'user-menu',
  require('./components/components/userMenu.vue')
)
Vue.component(
  'app-footer',
  require('./components/components/footer.vue')
)
Vue.component(
  'recaptcha',
  require('./components/components/recaptcha.vue')
)

const app = new Vue({
  router,
  store,
  el: '#app',
  render: h => h(require('./components/app.vue'))
});

export default app

if (process.env.NODE_ENV != 'production') {
  window.app = app
}
