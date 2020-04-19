<template>
	<transition name="bounce">
		<div class="panel panel-warning">
			<div class="panel-heading">Roles</div>
			<div class="panel-body">
				<paginate name="roles" :list="roles" :per="n ? n : 10"></paginate>
				<table class="table table-condensed table-hover table-responsive" v-if="roles.length > 0">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="role in paginated('roles')" :key="role.id">
							<td>{{ roles.indexOf(role) +1 }}</td>
							<td><router-link :to="'/user/admin/roles/'+role.id">{{role.name}}</router-link></td>
							<td>{{role.label}}</td>
						</tr>
					</tbody>
				</table>
				<div class="alert alert-danger" v-else>
					No Role attached to this permission.
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
		name: 'permission-role',
		props: ['permission'],
		data() {
			return {
				paginate: ['roles'],
				n: 10,
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
		computed: {
			roles () {
				return this.permission.roles
			}
		}
	}
</script>

<style>
	/**/
</style>
