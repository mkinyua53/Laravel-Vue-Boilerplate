<template>
	<transition name="bounce">
		<div class="panel panel-warning">
			<div class="panel-heading">Permissions</div>
			<div class="panel-body">
				<paginate name="permissions" :list="permissions" :per="n ? n : 10"></paginate>
				<table class="table table-responsive table-condensed table-hover" v-if="permissions.length > 0">
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
								<v-btn small class="pa-0 btn-danger pull-right" @click="detachAll" title="Remove all permissions from this user" v-if="permissions.length > 0">Detach all</v-btn>
							</td>
						</tr>
						<tr v-for="permission in paginated('permissions')" :key="permission.id">
							<td>{{ permissions.indexOf(permission) +1 }}</td>
							<td>{{ permission.name }}</td>
							<td>{{ permission.label }}</td>
							<td class="noprint">
								<v-btn class="pa-0 btn-warning" @click="detachPermission(permission)" title="Detach permission from user" :loading="detaching == permission.id">
									Detach
								</v-btn>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="alert alert-warning" v-else>
					No permission attached to this user.
				</div>
			</div>
			<div class="panel-footer noprint">
				<v-layout wrap>
					<v-flex xs9>
						<paginate-links for="permissions" :async="true" :hide-single-page="false" :show-step-links="true" class="list-inline text-center"></paginate-links>
					</v-flex>
					<v-flex xs3>
						<v-text-field label="Per Page" v-model.number="n" type="number" :max="permissions.length" :min="1" id="n"></v-text-field>
					</v-flex>
				</v-layout>
			</div>
		</div>
	</transition>
</template>

<script>
	export default {
		name: 'UserPermissions',
		props: ['user'],
		data() {
			return {
				paginate: ['permissions'],
				detaching: '',
				n: 10,
			}
		},
		methods: {
			detachPermission(permission) {
				swal({
					title: permission.name,
					text: 'Detach this permission from the user?',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: 'red',
					confirmButtonText:'Ok',
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				},
				function(){
					this.detaching = permission.id
					this.$http.post('permissions/'+permission.id+'/users/'+this.user.id+'/detach')
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
					title: 'Detach all permissions from <strong>'+this.user.email+'</strong>',
					html: true,
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: 'red',
					confirmButtonText:'Ok',
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				},
				function(){
					this.$http.post('permissions/users/'+this.user.id+'/detach')
					.then(response => {
						swal({title:'User striped of all permissions',type:'success',timer:1500})
						this.$emit('reloaduser')
					})
					.catch(err => {
						swal('Error '+err.status+': '+err.statusText,'Failed to Remove permissions from user','error')
					})
				}.bind(this))
			}
		},
		computed: {
			permissions() {
				return this.user.permissions
			}
		},
		watch: {
			'n': function() {
			  if (this.n < 1) {
			    this.n = 1
			  }
			  if (this.n > this.permissions.length) {
			    this.n = this.permissions.length
			  }
			}
		}
	}
</script>

<style>
	/**/
</style>
