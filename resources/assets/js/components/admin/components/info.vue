<template>
	<transition name="slide-fade">
		<v-container fluid>
			<v-layout wrap>
				<v-flex md8 sm10 xs12 class="pl-3">
					<h1>Introduction</h1>
					<p>Some actions provided by this application requires special permissions to be held by the user.</p>
					<p class="hidden">As an example, by the fact that you are reading this, then it means you have either the role of <span class="bg-info">Developer</span> or <span class="bg-info">SuperAdmnin</span></p><br>
					<p>You should add the permissions to your users as you see fit.</p>

					<h2>Roles</h2>
					<p>Roles normally contains a group of permissions</p>
					<p>Granting roles to users should therefore be done with caution as the user will automatically gain all the permissions held by that roles</p>
					<p>Visit each roles's page to see permissions held by the role.</p>
				</v-flex>
			</v-layout>
		</v-container>
	</transition>
</template>

<script>
	export default {
		name: 'roles-permissions-info',
		methods: {
			initAuth() {
				swal({
					title: 'Initialize Authorization priviledges?',
					text: 'This action will initialize authorization data or add new.<br>Existing user access will not be affected',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: 'red',
					confirmButtonText:'Ok',
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
				},
				function () {
					this.$http.get('admin/authorization/install')
					.then(res => {
						swal('Authorization updated successfully')
						this.$store.dispatch('users/roles')
						this.$store.dispatch('users/permissions')
					})
					.catch(err => {
						swal('Error '+err.status+': '+err.statusText,'Failed to Install authorization','error')
						this.$store.dispatch('users/roles')
						this.$store.dispatch('users/permissions')
					})
				}.bind(this))
			},
			resetAuth () {
				swal({
					title: 'Reset Authorization?',
					text: 'This action will delete and recreate authorization records.<br> Only the current user will have access after this.<br>Use this account to issue new authorization.',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: 'red',
					confirmButtonText:'Proceed',
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
				},
				function () {
					this.$http.post('admin/authorization/reset')
					.then(res => {
						swal('Authorization data has been restored to the OOB configuration.<br> You should now issue permissions afresh.')
						this.$store.dispatch('users/roles')
						this.$store.dispatch('users/permissions')
					})
					.catch(err => {
						swal('Error '+err.status+': '+err.statusText,'Failed to Reset','error')
						this.$store.dispatch('users/roles')
						this.$store.dispatch('users/permissions')
					})
				}.bind(this))
			}
		}
	}
</script>

<style scoped>
	.col-md-8 {
		background-color: white;
		padding: 15px;
		box-sizing: border-box;
	}
</style>
