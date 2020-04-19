<template>
	<transition name="bounce">
		<div class="panel panel-warning">
			<div class="panel-heading">Users</div>
			<div class="panel-body">
				<v-text-field label="Search" v-model="filterBy" prepend-icon="search" :disabled="users.length < 1" :append-icon="filterBy.length > 0 ? 'close' : ''" :append-icon-cb="() => (filterBy = '')"></v-text-field>
				<paginate name="filtered" :list="filtered" :per="n ? n : 10"></paginate>
				<table class="table table-responsive table-condensed table-hover" v-if="users.length > 0">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th class="noprint"></th>
						</tr>
					</thead><tbody>
						<tr v-for="user in paginated('filtered')" :key="user.email">
							<td>{{filtered.indexOf(user) +1}}</td>
							<td><router-link :to="'/users/'+user.id">{{ user.name }}</router-link></td>
							<td><router-link :to="'/users/'+user.id">{{ user.email }}</router-link></td>
							<td class="noprint">
								<button class="btn btn-danger btn-sm" @click="detachpermission(user)" :title="'Revoke the user\'s access to '+permission.name+'. !! User may still have roles that have this permission. !!'">
									<span v-if="revoking == user.id">Revoking...</span>
									<span v-else>Revoke</span>
								</button>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="alert alert-danger" v-else>
					No user directly attached to this permission.
				</div>
				<div class="alert alert-info" v-if="users.length > 0 && filtered.length < 1">
					Your search for "<strong>{{filterBy}}</strong>" did not match any user's email attached to this permission.
				</div>
			</div>
			<div class="panel-footer noprint">
				<v-layout wrap>
					<v-flex xs9>
						<paginate-links for="filtered" :async="true" :show-step-links="true" :hide-single-page="false" class="list-inline text-center"></paginate-links>
					</v-flex>
					<v-flex xs3>
						<v-text-field label="Per Page" v-model.number="n" type="number" :max="users.length" :min="1" id="n"></v-text-field>
					</v-flex>
				</v-layout>
			</div>
		</div>
	</transition>
</template>

<script>
	export default {
		name: 'permission-users',
		props: ['permission'],
		data() {
			return {
				paginate: ['filtered'],
				revoking: '',
				filterBy: '',
				n: 10,
			}
		},
		methods: {
			detachpermission(user) {
				swal({
					title: user.email,
					text: 'Revoke the current permission <strong>('+this.permission.name+')</strong> from this user? Note that the user may still have access to this permission if they are assigned a role with <strong>('+this.permission.name+')</strong>',
					type: 'warning',
					html: true,
					showCancelButton: true,
					confirmButtonColor: 'red',
					confirmButtonText:'Ok',
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				},
				function(){
					this.$http.post('permissions/'+this.permission.id+'/users/'+user.id+'/detach')
					.then(response => {
						swal({title:'User Permission Revoked',type:'success',timer:1500})
						this.revoking = '',
						this.$emit('reloadpermission')
						this.$store.dispatch('users/permissions')
					})
					.catch(err => {
						this.revoking = ''
						swal('Error '+err.status+': '+err.statusText,'Failed to Revoke Permission','error')
					})
				}.bind(this))
			}
		},
		computed: {
			filtered() {
				return this.users.filter((users) => {
					return users.email.toLowerCase().includes(this.filterBy.toLowerCase())
				})
			},
			users () {
				return this.permission.users
			}
		},
		watch: {
			'n': function() {
			  if (this.n < 1) {
			    this.n = 1
			  }
			  if (this.n > this.users.length) {
			    this.n = this.users.length
			  }
			}
		}
	}
</script>

<style>
	/**/
</style>
