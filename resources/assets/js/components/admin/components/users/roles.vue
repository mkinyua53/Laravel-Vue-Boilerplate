<template>
	<transition name="bounce">
		<div class="panel panel-warning">
			<div class="panel-heading">Roles</div>
			<div class="panel-body">
				<paginate name="roles" :list="roles" :per="n ? n : 10"></paginate>
				<table class="table table-responsive table-condensed table-hover" v-if="roles.length > 0">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Description</th>
							<th class="noprint"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="4">
								<v-btn small class="btn-danger pa-0 pull-right" @click="detachAll" title="Detach all roles from the user">Detach all</v-btn>
							</td>
						</tr>
						<tr v-for="role in paginated('roles')" :key="role.id">
							<td>{{ roles.indexOf(role) +1 }}</td>
							<td>{{ role.name }}</td>
							<td>{{ role.label }}</td>
							<td class="noprint">
								<v-btn small class="btn-warning pa-0" @click="detachRole(role)" title="Detach Role from user" :loading="detaching == role.id">
									Detach
								</v-btn>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="alert alert-warning" v-else>
					No role attached to this user.
				</div>
			</div>
			<div class="panel-footer noprint">
				<v-layout wrap>
					<v-flex xs9>
						<paginate-links for="roles" :async="true" :hide-single-page="false" :show-step-links="true" class="list-inline text-center"></paginate-links>
					</v-flex>
					<v-flex xs3>
						<v-text-field label="Per Page" v-model.number="n" type="number" :max="roles.length" :min="1" id="n"></v-text-field>
					</v-flex>
				</v-layout>
			</div>
		</div>
	</transition>
</template>

<script>
	export default {
		name: 'UserRoles',
		props: ['user'],
		data() {
			return {
				paginate: ['roles'],
				detaching: '',
				n: 10
			}
		},
		methods: {
			detachRole(role) {
				swal({
					title: role.name,
					text: 'Detach this role from the user?',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: 'red',
					confirmButtonText:'Ok',
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				},
				function(){
					this.detaching = role.id
					this.$http.post('roles/'+role.id+'/users/'+this.user.id+'/detach')
					.then(response => {
						swal({title:'Detach Success',type:'success',timer:1500})
						this.detaching = ''
						this.$emit('reloaduser')
					})
					.catch(err => {
						this.detaching = '',
						swal('Error '+err.status+': '+err.statusText,'Failed to Detach','error')
					})
				}.bind(this))
			},
			detachAll(){
				swal({
					title: 'Detach all roles from <strong>'+this.user.email+'</strong>',
					html: true,
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: 'red',
					confirmButtonText:'Ok',
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				},
				function(){
					this.$http.post('roles/users/'+this.user.id+'/detach')
					.then(response => {
						swal({title:'User striped of all roles',type:'success',timer:1500})
						this.$emit('reloaduser')
					})
					.catch(err => {
						swal('Error '+err.status+': '+err.statusText,'Failed to Remove roles from user','error')
					})
				}.bind(this))
			}
		},
		computed: {
			roles () {
				return this.user.roles
			}
		},
		watch: {
			'n': function() {
			  if (this.n < 1) {
			    this.n = 1
			  }
			  if (this.n > this.roles.length) {
			    this.n = this.roles.length
			  }
			}
		}
	}
</script>

<style>
	/**/
</style>
