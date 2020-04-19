<template>
	<transition name="">
		<v-container fluid>
			<v-layout wrap v-if="role.id">
				<v-flex xs12>
					<h3 class="text-center">Role - {{ role.name }}</h3>
				</v-flex>
				<v-flex xs12 md6 sm6>
					<ul class="list-group">
						<li class="list-group-item"><strong>Role's Name: </strong>{{ role.name }}</li>
						<li class="list-group-item"><strong>Description: </strong>{{ role.label }}</li>
					</ul>
				</v-flex>
				<v-flex md6 sm6 xs12>
					<users :role="role" @reloadrole="reloadRoles"></users>
				</v-flex>
				<v-flex md6 sm6 xs12>
					<permissions :role="role"></permissions>
				</v-flex>
				<v-flex md6 sm6 xs12 class="noprint">
					<attach :role="role" @reloadrole="reloadRoles"></attach>
				</v-flex>
			</v-layout>
		</v-container>
	</transition>
</template>

<script>
	import { mapGetters } from 'vuex'
	export default {
		name: 'Role',
    metaInfo () {
      return {
        title: 'Admin DashBoard - Role - ' + this.role.name,
        titleTemplate: '%s | ' + this.$title
      }
    },
		components: {
			attach: require('./attach.vue'),
			users: require('./users.vue'),
			permissions: require('./permissions.vue')
		},
		data() {
			return {
				loading: true,
			}
		},
		methods: {
			fetchData() {
				this.$http.get('roles/' + this.$route.params.role)
				.then(res => {
					this.$store.commit('users/role', { role: res.body })
				})
				.catch(err => {
					swal('Error '+err.status+': '+err.statusText,'Failed to load role','error')
				})
			},
			reloadRoles () {
				this.fetchData()
			}
		},
		created() {
			this.fetchData()
		},
		watch: {
			'$route.params.role': 'fetchData'
		},
		computed: {
			role () {
			  return this.$store.getters['users/role']
			},
		}
	}
</script>

<style>
	/**/
</style>
