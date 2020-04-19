<template>
	<transition name="bounce">
		<div class="panel panel-danger">
			<div class="panel-heading" @click="shown = !shown">
				Attach User
				<span class="pull-right noprint">
					<i class="fa fa-arrow-down" v-if="! shown" aria-hidden="true"></i>
					<i class="fa fa-arrow-up" v-if="shown" aria-hidden="true"></i>
					<span class="sr-only">Hide/Show action panel</span>
				</span>
			</div>
			<div class="panel-body" v-if="shown">
				<form @submit.prevent="attachUser(user)">
					<div class="form-group">
						<label for="user_id">Select User</label>
						<select name="User" id="user_id" v-model="user.user_id" v-validate="'required'" class="form-control" required>
							<option value=""></option>
							<option v-for="appuser in users" :value="appuser.id" :key="appuser.id">{{appuser.email}}</option>
						</select>
					</div>
					<button class="btn btn-primary btn-block" type="submit">Submit<span v-if="attaching">ting...</span></button>
				</form>
			</div>
		</div>
	</transition>
</template>

<script>
	import { mapGetters } from 'vuex'
	export default {
		name: 'AttachRole',
		props: ['role'],
		data() {
			return {
				shown: false,
				attaching: false,
				user: {
					user_id: ''
				}
			}
		},
		methods: {
			attachUser(user) {
				swal({
					title: this.role.name,
					text: 'Attach selected user to this role?',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: 'red',
					confirmButtonText:'Attach',
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				},
				function(){
					this.attaching = true
					this.$http.post('roles/'+this.role.id+'/users/'+this.user.user_id+'/attach')
					.then(response => {
						swal({title:'Success',type:'success',timer:1500})
						this.attaching = false
						this.$emit('reloadrole')
						this.$store.dispatch('users/roles')
					})
					.catch(err => {
						this.attaching = false
						swal('Error '+err.status+': '+err.statusText,'Failed to Attach role to user.','error')
					})
				}.bind(this))
			}
		},
		created() {
			this.$store.dispatch('users/users')
		},
		computed: {
			users () {
			  return this.$store.getters['users/users']
			},
		}
	}
</script>

<style>
	/**/
</style>
