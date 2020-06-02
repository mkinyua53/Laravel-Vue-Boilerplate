import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: require('../../components/default.vue').default,
    children: [
      {
        path: '',
        component: require('../../components/pages/home.vue').default,
        children: [
          {
            path: '',
            name: 'Home',
            component: require('../../components/pages/welcome.vue').default
          },
          {
            path: 'user',
            component: require('../../components/users/profile.vue').default
          },
        ]
      },
      {
        path: 'about',
        name: 'About'
      },
      {
        path: 'contact',
        name: 'Contact'
      },
      {
        path: '/legal',
        component: require('../../components/legal/index.vue').default,
        children: [
          {
            path: '/privacy',
            name: 'Privacy Policy',
            component: require('../../components/legal/privacy.vue').default
          },
          {
            path: '/terms',
            name: 'Terms of Use',
            component: require('../../components/legal/terms.vue').default
          },
        ]
      },
      {
        path: '/admin',
        meta: { forAuth: true },
        component: require('../../components/dashboards/admin.vue').default,
        children: [
          {
            path: '',
            component: require('../../components/admin/index.vue').default,
            children: [
              //
            ]
          },
          {
            path: 'users',
            name: 'Users',
            component: require('../../components/admin/components/users/users.vue').default,
          },
          {
            path: 'users/:user',
            name: 'Admin View User',
            component: require('../../components/admin/components/users/show.vue').default
          },
          {
            path: 'roles',
            name: 'Roles',
            component: require('../../components/admin/components/roles/roles.vue').default
          },
          {
            path: 'roles/:role',
            name: 'Admin View role',
            component: require('../../components/admin/components/roles/show.vue').default
          },
          {
            path: 'permissions',
            name: 'Permissions',
            component: require('../../components/admin/components/permissions/permissions.vue').default
          },
          {
            path: 'permissions/:permission',
            name: 'Admin View permission',
            component: require('../../components/admin/components/permissions/show.vue').default
          },
        ]
      },
      {
        path: 'login',
        name: 'Login',
        component: require('../../components/pages/login.vue').default
      },
      {
        path: 'register',
        name: 'Register',
        meta: {
          forGuest: true
        },
        component: require('../../components/pages/register.vue').default
      },
      {
        path: 'logout',
        name: 'LogOut',
        component: require('../../components/pages/logout.vue').default
      },
      {
        path: 'dashboard',
        meta: {
          forAuth: true
        },
        component: require('../../components/pages/dash.vue').default,
        children: [
          {
            path: '',
            name: 'DashBoard',
            component: require('../../components/pages/dashboard.vue').default,
          },
        ]
      },
      {
        path: '/user',
        meta: {
          forAuth: true
        },
        component: require('../../components/users/index.vue').default,
        children: [
          {
            path: 'notifications',
            name: 'User Notifications',
            component: require('../../components/components/notifications.vue').default
          },
          {
            path: ':user',
            component: require('../../components/users/user.vue').default,
            children: [
              {
                path: '',
                name: 'View User Profile',
                component: require('../../components/user/profile.vue').default
              }
            ]
          }
        ]
      },
      {
        path: 'users',
        meta: {
          forAuth: true,
        },
        component: require('../../components/users/index.vue').default,
        children: [
          {
            path: ':user',
            component: require('../../components/users/user.vue').default,
            children: [
              {
                path: '',
                name: 'View User',
                component: require('../../components/user/profile.vue').default
              }
            ]
          }
        ]
      }
    ],
  },
  {
    path: '/contracts',
    redirect: '/user/contracts'
  },
  {
    path: '/contracts/create',
    redirect: '/user/contracts/create'
  },
  {
    path: '/unauthorized',
    name: '403',
    component: require('../../components/pages/403.vue').default
  },
  {
    path: '/user-inactive',
    name: 'User InActive',
    component: require('../../components/pages/310.vue').default
  },
  {
    path: '/activated',
    name: 'Activated',
    component: require('../../components/pages/activated.vue').default
  },
  {
    path: '/server-error',
    name: '500',
    component: require('../../components/pages/500.vue').default
  },
  {
    path: '*',
    component: require('../../components/pages/404.vue').default,
    name: 'Not Found',
  }
]

const router = new VueRouter({
  mode:  'hash',
  routes,
  base: '/',
  linkActiveClass: 'active'
})

export default router
