## About

Boilerplate for a [PWA](https://web.dev/progressive-web-apps/) built with [Laravel 5.5](https://laravel.com/docs/5.5) and [VueJs](https://vuejs.org/v2/guide).

Includes a general */dashboard* and an */admin* dashboard

## Install
Use Composer
```bash
composer create-project mkinyua53/laravel-vue-boilerplate myproject
```
```bash
cd myproject
npm run install
```
And then you can run watch to start on your vue project
```bash
npm run watch
```

## Notable Packages
### Backend
- [Laravel Passport](https://laravel.com/docs/5.5/passport)
- [MKinyua53 Authorization](https://github.com/MKinyua53/authorization)

### Frontend
- [Vuex](https://vuex.vuejs.org/guide/)
- [Vue-Resoource](https://github.com/pagekit/vue-resource)
- [Vue-Router](https://router.vuejs.org/guide/)
- [Vuetify](https://v1.vuetifyjs.com/en/getting-started/quick-start)
- [Vue-meta](https://vue-meta.nuxtjs.org/guide/)

## Authorization
Please refer to the [Authorization](https://github.com/MKinyua53/authorization) documentation for initial setup.

An [InstallController](app/Http/Controllers/InstallController.php) is provided to quickly set-up your roles and permissions.

In the _permissions()_ and _roles()_ add your permissions and roles respectively to the array.

Go to the link */api/auth/install* or call the _installAuth()_ function from a route/controller to install the permissions and roles to the database. You can run as many times as you wish particullarly when you add new items in the arrays.

The _resetAuth()_ function can be used to reset all roles and permissions to the default.

### Vue Authorization
In Vue components, there a several methods to check authority. They return boolean value

| Method | Accepts | Description |
| --- | --- | ---|
| this.$auth.hasPermission(variable) | string | Checks if a user has a certain permission |
| this.$auth.hasPermissions(variable) | array | Checks if a user has all the given permissions |
| this.$auth.hasAnyPermissions(variable) | array | Checks if a user has any of the permissions |
| this.$auth.hasRole(variable) | string | Checks if a user has a certain role |
| this.$auth.hasRoles(variable) | array | Checks if a user has all the given roles |
| this.$auth.hasAnyRoles(variable) | array | Checks if a user has any of the role |


## Credit
Find me on [twitter](https://twitter.com/mkinyua53)
