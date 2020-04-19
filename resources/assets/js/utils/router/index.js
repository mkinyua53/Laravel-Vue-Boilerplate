import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: require('../../components/default.vue'),
    children: [
      {
        path: '',
        component: require('../../components/pages/home.vue'),
        children: [
          {
            path: '',
            name: 'Home',
            component: require('../../components/pages/welcome.vue')
          },
          {
            path: 'user',
            component: require('../../components/users/profile.vue')
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
        component: require('../../components/legal/index.vue'),
        children: [
          {
            path: '/privacy',
            name: 'Privacy Policy',
            component: require('../../components/legal/privacy.vue')
          },
          {
            path: '/terms',
            name: 'Terms of Use',
            component: require('../../components/legal/terms.vue')
          },
        ]
      },
      {
        path: '/admin',
        meta: { forAuth: true },
        component: require('../../components/dashboards/admin.vue'),
        children: [
          {
            path: '',
            component: require('../../components/admin/index.vue'),
            children: [
              //
            ]
          },
          {
            path: 'users',
            name: 'Users',
            component: require('../../components/admin/components/users/users.vue'),
          },
          {
            path: 'users/:user',
            name: 'Admin View User',
            component: require('../../components/admin/components/users/show.vue')
          },
          {
            path: 'roles',
            name: 'Roles',
            component: require('../../components/admin/components/roles/roles.vue')
          },
          {
            path: 'roles/:role',
            name: 'Admin View role',
            component: require('../../components/admin/components/roles/show.vue')
          },
          {
            path: 'permissions',
            name: 'Permissions',
            component: require('../../components/admin/components/permissions/permissions.vue')
          },
          {
            path: 'permissions/:permission',
            name: 'Admin View permission',
            component: require('../../components/admin/components/permissions/show.vue')
          },
        ]
      },
      {
        path: 'login',
        name: 'Login',
        component: require('../../components/pages/login.vue')
      },
      {
        path: 'register',
        name: 'Register',
        meta: {
          forGuest: true
        },
        component: require('../../components/pages/register.vue')
      },
      {
        path: 'logout',
        name: 'LogOut',
        component: require('../../components/pages/logout.vue')
      },
      {
        path: 'dashboard',
        meta: {
          forAuth: true
        },
        component: require('../../components/pages/dash.vue'),
        children: [
          {
            path: '',
            name: 'DashBoard',
            component: require('../../components/pages/dashboard.vue'),
          },
        ]
      },
      {
        path: '/user',
        meta: {
          forAuth: true
        },
        component: require('../../components/users/index.vue'),
        children: [
          {
            path: 'notifications',
            name: 'User Notifications',
            component: require('../../components/components/notifications.vue')
          },
          {
            path: ':user',
            component: require('../../components/users/user.vue'),
            children: [
              {
                path: '',
                name: 'View User Profile',
                component: require('../../components/user/profile.vue')
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
        component: require('../../components/users/index.vue'),
        children: [
          {
            path: ':user',
            component: require('../../components/users/user.vue'),
            children: [
              {
                path: '',
                name: 'View User',
                component: require('../../components/user/profile.vue')
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
    component: require('../../components/pages/403.vue')
  },
  {
    path: '/user-inactive',
    name: 'User InActive',
    component: require('../../components/pages/310.vue')
  },
  {
    path: '/activated',
    name: 'Activated',
    component: require('../../components/pages/activated.vue')
  },
  {
    path: '/server-error',
    name: '500',
    component: require('../../components/pages/500.vue')
  },
  {
    path: '*',
    component: require('../../components/pages/404.vue'),
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
