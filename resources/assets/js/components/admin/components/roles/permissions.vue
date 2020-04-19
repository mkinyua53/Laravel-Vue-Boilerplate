<template>
	<transition name="bounce">
		<div class="panel panel-warning">
			<div class="panel-heading">Permissions</div>
			<div class="panel-body">
				<paginate name="permissions" :list="permissions" :per="n ? n : 10"></paginate>
				<table class="table table-condensed table-striped table-responsive" v-if="permissions.length > 0">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="permission in paginated('permissions')" :key="permission.id">
							<td>{{ permissions.indexOf(permission) +1 }}</td>
							<td><router-link :to="'/user/admin/permissions/'+permission.id">{{permission.name}}</router-link></td>
							<td>{{permission.label}}</td>
						</tr>
					</tbody>
				</table>
				<div v-else class="alert alert-info">
					No permission attached to this role.
				</div>
			</div>
			<div class="panel-footer noprint">
				<v-layout wrap>
					<v-flex xs9>
						<paginate-links for="permissions" :show-step-links="true" :hide-single-page="false" :async="true" class="list-inline text-center"></paginate-links>
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
		name: 'role-permissions',
		props: ['role'],
		data() {
			return {
				paginate: ['permissions'],
				n: 10,
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
		computed: {
			permissions () {
				return this.role.permissions
			}
		}
	}
</script>

<style>
	/**/
</style>
