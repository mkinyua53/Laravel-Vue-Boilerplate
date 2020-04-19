<template>
  <transition name="slide-fade">
    <v-container fluid>
      <v-layout wrap>
        <v-flex xs12>
          <form @submit.prevent="attachRole(role)">
            <v-select :items="roles" :item-text="'name'" :item-value="'id'" prepend-icon="user" label="Select Role" autocomplete required hint="" v-model="role" clearable placeholder="Select Role ...">
              <template slot="selection" slot-scope="data">
                <v-chip
                  close
                  @input="data.parent.selectItem(data.item)"
                  :selected="data.selected"
                  class="chip--select-multi"
                  :key="JSON.stringify(data.item)"
                >
                  {{ data.item.name }}
                </v-chip>
              </template>
              <template slot="item" slot-scope="data">
                <template v-if="typeof data.item !== 'object'">
                  <v-list-tile-content v-text="data.item"></v-list-tile-content>
                </template>
                <template v-else>
                  <v-list-tile-avatar>
                    <v-icon>fa-hand-o-right</v-icon>
                  </v-list-tile-avatar>
                  <v-list-tile-content>
                    <v-list-tile-title v-html="data.item.name" class="red--text"></v-list-tile-title>
                    <v-list-tile-title v-html="data.item.label" style="border-bottom: 1px solid;"></v-list-tile-title>
                  </v-list-tile-content>
                </template>
              </template>
            </v-select>
            <v-btn type="submit" class="pa-0 btn-primary">Submit</v-btn>
          </form>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>
<script>
  export default {
    name: 'AttachRoleToUser',
    props: ['user'],
    data () {
      return {
        role: '',
        attaching: false,
      }
    },
    methods: {
      fetchData () {
         this.$store.dispatch('users/roles')
      },
      attachRole (role) {
        swal({
          title: 'Attach Role to user',
          text: 'The user will inherit all permissions attached to this role',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: 'red',
          confirmButtonText:'Attach',
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function () {
          this.attaching = true
          this.$http.post('roles/'+role+'/users/'+this.user.id+'/attach')
					.then(response => {
						swal({title:'Success',type:'success',timer:1500})
						this.attaching = false
						this.$emit('reloaduser')
						this.$store.dispatch('users/roles')
					})
					.catch(err => {
						this.attaching = false
						swal('Error '+err.status+': '+err.statusText,'Failed to Attach role to user.','error')
					})
        }.bind(this))
      }
    },
    created () {
      this.fetchData()
    },
    computed: {
      roles () {
        return this.$store.getters['users/roles']
      }
    },
    watch: {
      '$route': 'fetchData',
    }
  }
</script>
<style>
   /**/
</style>
