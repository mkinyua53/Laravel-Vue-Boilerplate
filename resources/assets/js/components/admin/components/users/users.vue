<template>
	<transition name="slide-fade">
		<v-container fluid>
			<v-layout wrap>
				<v-flex xs12>
					<h3 class="text-center">Users</h3>
				</v-flex>
				<v-flex md8 sm12 xs12>
					<v-text-field label="Search" v-model="filterBy" prepend-icon="search" :disabled="users.length < 1" :append-icon="filterBy.length > 0 ? 'close' : ''" :append-icon-cb="() => (filterBy = '')" hint="Search by Email"></v-text-field>
					<div class="card">
						<div class="card__title">Users</div>
						<div class="card__text" v-if="users.length > 0">
							<paginate name="filtered" :list="filtered" :per="n ? n : 10"></paginate>
							<table class="table table-condensed table-responsive table-hover table-bordered">
								<thead v-if="filtered.length > 0">
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Email</th>
										<th>Type</th>
										<th>Permission<span class="text-danger">*</span></th>
										<th>Roles</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="user in paginated('filtered')" :key="user.email">
										<td>{{ filtered.indexOf(user) +1}}</td>
										<td><router-link :to="'/admin/users/'+user.id">{{ user.name }}</router-link></td>
										<td><router-link :to="'/admin/users/'+user.id">{{ user.email }}</router-link></td>
										<td>
											<span v-if="!user.memberable_type"></span>
											<span v-else-if="user.memberable_type == 'App\\Teacher'">
												<v-btn icon flat class="pa-0" title="This is a teacher's account">
													Teacher
												</v-btn>
											</span>
											<span v-else-if="user.memberable_type == 'App\\Student'">
												<v-btn icon flat class="pa-0" :to="'/students/' + user.memberable_id" title="Student Account">
													Student
												</v-btn>
											</span>
										</td>
										<td>{{ user.permissions_count }}</td>
										<td>{{ user.roles_count }}</td>
										<td>
											<v-btn small icon @click="deleteUser(user)" flat class="pa-0">
												<v-icon color="red">fa-trash-o</v-icon>
											</v-btn>
										</td>
									</tr>
								</tbody>
							</table>
							<span class="text-danger">*</span><span class="text-warning bg-info">Remember that the user will inherit all the permissions owned by any role the user may have</span>
							<div class="alert alert-info" v-if="filtered.length < 1">
								Your search for "<strong>{{filterBy}}</strong>" did not match any  user's email.
							</div>
						</div>
						<div class="card__actions noprint">
							<v-layout wrap>
								<v-flex xs9>
									<paginate-links for="filtered" :async="true" :hide-single-page="true" :show-step-links="true" class="text-center list-inline"></paginate-links>
								</v-flex>
								<v-flex xs3>
									<v-text-field label="Per Page" v-model.number="n" type="number" :max="users.length" :min="1" id="n"></v-text-field>
								</v-flex>
							</v-layout>
						</div>
					</div>
				</v-flex>
			</v-layout>
		</v-container>
	</transition>
</template>

<script>
	export default {
		name: 'Users',
    metaInfo () {
      return {
        title: 'Admin DashBoard - Users',
        titleTemplate: '%s | ' + this.$title
      }
    },
		data() {
			return {
				filterBy: '',
				paginate: ['filtered'],
				n: 10,
			}
		},
		methods: {
			deactivateUser(user) {
				swal({
					title: 'User Deactivation',
					text: 'Deactivate this user - <strong>'+user.email+'</strong>?',
					type: 'warning',
					html: true,
					showCancelButton: true,
					confirmButtonColor: 'red',
					confirmButtonText:'Ok',
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				},
				function(){
					this.$http.put('users/'+user.id+'/activate')
					.then(response => {
						this.$store.dispatch('users/users')
						swal({title:'Status Changed',type:'success',timer:1500})
					})
					.catch(err => {
						swal('Error '+err.status+': '+err.statusText,'Failed to deactivate','error')
					})
				}.bind(this))
			},
			activateUser(user) {
				swal({
					title: 'User Activation',
					text: 'Activate this user - <strong>'+user.email+'</strong>?',
					type: 'warning',
					html: true,
					showCancelButton: true,
					confirmButtonColor: 'green',
					confirmButtonText:'Ok',
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				},
				function(){
					this.$http.put('users/'+user.id+'/activate')
					.then(response => {
						this.$store.dispatch('users/users')
						swal({title:'Status Changed',type:'success',timer:1500})
					})
					.catch(err => {
						swal('Error '+err.status+': '+err.statusText,'Failed to deactivate','error')
					})
				}.bind(this))
			},
			deleteUser(user) {
				swal({
					title: 'Delete User?',
					text: user.name + ' - ' + user.email,
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: 'red',
					confirmButtonText:'Delete',
					closeOnConfirm: false,
					showLoaderOnConfirm: true,
				},
				function () {
					this.$http.delete('users/' + user.id)
					.then(res => {
						this.$store.dispatch('users/users')
						swal({ title: 'User Deleted', type: 'success', timer: 2500 })
					})
					.catch(err => {
						swal('Error '+err.status+': '+err.statusText,'Failed to delete','error')
						this.$store.dispatch('users/users')
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
			filtered() {
				return this.users.filter((users) => {
					return users.email.toLowerCase().includes(this.filterBy.toLowerCase())
				})
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
