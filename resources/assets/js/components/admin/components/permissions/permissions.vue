<template>
	<transition name="slide-fade">
		<v-container fluid>
			<v-layout wrap>
				<v-flex xs12>
					<h3 class="text-center">Permissions</h3>
				</v-flex>
				<v-flex md8 sm10 xs12>
					<v-text-field label="Search" v-model="filterBy" prepend-icon="search" :disabled="permissions.length < 1" :append-icon="filterBy.length > 0 ? 'close' : ''" :append-icon-cb="() => (filterBy = '')"></v-text-field>
					<div class="panel panel-info">
						<div class="panel-heading">Permissions</div>
						<div class="panel-body">
							<paginate name="filtered" :list="filtered" :per="n ? n : 10"></paginate>
							<table class="table table-responsive table-condensed table-hover">
								<thead v-if="filtered.length > 0">
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Description</th>
										<th>Users<span class="text-danger">*</span></th>
										<th>Roles</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="permission in paginated('filtered')" :key="permission.id">
										<td>{{filtered.indexOf(permission) +1}}</td>
										<td><router-link :to="'/admin/permissions/'+permission.id">{{permission.name}}</router-link></td>
										<td>{{permission.label}}</td>
										<td>{{permission.users.length}}</td>
										<td>{{permission.roles.length}}</td>
									</tr>
								</tbody>
							</table>
							<transition-group name="custom-classes-transition" enter-active-class="animated zoomInUp" leave-active-class="animated zoomOutDown">
								<div :key="'no search'" class="alert alert-danger" v-if="filtered.length < 1 && permissions.length > 0">
									Your search for "<strong>{{filterBy}}</strong>" did not match any permission.
								</div>
								<div :key="'no permissions'" class="alert alert-danger" v-if=" permissions.length < 1">
									No permissions found.
								</div>
							</transition-group>
						</div>
						<div class="panel-footer noprint">
							<v-layout wrap>
								<v-flex xs9>
									<paginate-links for="filtered" :show-step-links="true" :hide-single-page="false" :async="true" class="list-inline text-center"></paginate-links>
								</v-flex>
								<v-flex xs3>
									<v-text-field label="Per Page" v-model.number="n" type="number" :max="permissions.length" :min="1" id="n"></v-text-field>
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
		name: 'permissions',
    metaInfo () {
      return {
        title: 'Admin DashBoard - Permissions',
        titleTemplate: '%s | ' + this.$title
      }
    },
		data() {
			return {
				paginate: ['filtered'],
				filterBy: '',
				n: 10,
			}
		},
		computed:{
			permissions () {
				return this.$store.getters['users/permissions']
			},
			filtered() {
				return this.permissions.filter((permissions) => {
					return permissions.name.toLowerCase().includes(this.filterBy.toLowerCase()) || permissions.label.toLowerCase().includes(this.filterBy.toLowerCase())
				})
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
		},
		created () {
			this.fetchData()
		},
		methods: {
			fetchData () {
				this.$store.dispatch('users/permissions')
			}
		}
	}
</script>

<style>
	/**/
</style>
