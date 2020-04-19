<template>
	<transition name="slide-fade">
		<v-container fluid>
			<v-layout wrap>
				<v-flex xs12>
					<h3 class="text-center">Roles</h3>
				</v-flex>
				<v-flex md8 sm10 xs12>
					<v-text-field label="Search" v-model="filterBy" prepend-icon="search" :disabled="roles.length < 1" :append-icon="filterBy.length > 0 ? 'close' : ''" :append-icon-cb="() => (filterBy = '')"></v-text-field>
					<div class="panel panel-info">
						<div class="panel-heading">Roles</div>
						<div class="panel-body">
							<paginate name="filtered" :list="filtered" :per="n ? n : 10"></paginate>
							<table class="table table-responsive table-condensed table-hover">
								<thead v-show="filtered.length > 0">
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Description</th>
										<th>Users</th>
										<th>Permissions</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="role in paginated('filtered')" :key="role.id">
										<td>{{filtered.indexOf(role) +1}}</td>
										<td><router-link :to="'/admin/roles/'+role.id">{{role.name}}</router-link></td>
										<td>{{role.label}}</td>
										<td>{{role.users.length}}</td>
										<td>{{role.permissions.length}}</td>
									</tr>
								</tbody>
							</table>
							<transition-group name="custom-classes-transition" enter-active-class="animated zoomInUp" leave-active-class="animated zoomOutDown">
								<div class="alert alert-danger" :key="'no search'" v-if="filtered.length < 1 && roles.length > 0">
									Your search for "<strong>{{filterBy}}</strong>" did not match any role.
								</div>
								<div class="alert alert-danger" :key="'no roles'" v-if=" roles.length < 1">
									No roles found
								</div>
							</transition-group>
						</div>
						<div class="panel-footer noprint">
							<v-layout wrap>
								<v-flex xs9>
									<paginate-links for="filtered" :async="true" :show-step-links="true" :hide-single-page="true" :limit="5" class="text-center list-inline"></paginate-links>
								</v-flex>
								<v-flex xs3>
									<v-text-field label="Per Page" v-model.number="n" type="number" :max="roles.length" :min="1" id="n"></v-text-field>
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
		name: 'roles',
    metaInfo () {
      return {
        title: 'Admin DashBoard - Roles',
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
			roles () {
				return this.$store.getters['users/roles']
			},
			filtered() {
				return this.roles.filter((roles) => {
					return roles.name.toLowerCase().includes(this.filterBy.toLowerCase()) || roles.label.toLowerCase().includes(this.filterBy.toLowerCase())
				})
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
		},
		created () {
			this.fetchData()
		},
		methods: {
			fetchData () {
				this.$store.dispatch('users/roles')
			}
		}
	}
</script>

<style>
	/**/
</style>
