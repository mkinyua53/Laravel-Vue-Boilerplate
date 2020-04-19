<template>
	<transition name="slide-fade">
		<v-container fluid>
			<v-layout wrap v-if="permission.id">
				<v-flex xs12>
					<h3 class="text-center">Permission - {{ permission.name }}</h3>
				</v-flex>
				<v-flex md6 sm6 xs12>
					<ul class="list-group">
						<li class="list-group-item"><b>Permission</b> - {{permission.name}}</li>
						<li class="list-group-item"><b>Description</b> - {{permission.label}}</li>
					</ul>
				</v-flex>
				<v-flex md6 sm6 xs12>
					<users :permission="permission" @reloadpermission="reloadPermissions"></users>
				</v-flex>
				<v-flex md6 sm6 xs12>
					<roles :permission="permission"></roles>
				</v-flex>
				<v-flex md6 sm6 xs12>
					<attach :permission="permission" @reloadpermission="reloadPermissions"></attach>
				</v-flex>
			</v-layout>
		</v-container>
	</transition>
</template>

<script>
	export default {
		name: 'Permission',
    metaInfo () {
      return {
        title: 'Admin DashBoard - Permission - ' + this.permission.name,
        titleTemplate: '%s | ' + this.$title
      }
    },
		components: {
			users: require('./users.vue'),
			roles: require('./roles.vue'),
			attach: require('./attach.vue')
		},
		data() {
			return {
				loading: true
			}
		},
		methods: {
			fetchData() {
				this.$http.get('permissions/' + this.$route.params.permission)
				.then(res => {
					this.$store.commit('users/permission', { permission: res.body })
				})
				.catch(err => {
					swal('Error '+err.status+': '+err.statusText,'Failed to load permission','error')
				})
			},
			reloadPermissions () {
				this.fetchData()
			}
		},
		created() {
			this.fetchData()
		},
		computed: {
			permission () {
				return this.$store.getters['users/permission']
			},
		},
		watch: {
			'$route.params.permission': 'fetchData'
		}
	}
</script>

<style>
	/**/
</style>
