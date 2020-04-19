<template>
  <transition name="">
    <v-container fluid>
      <title>User Profile | {{ user.name }} | {{ $store.state.title }}</title>
      <v-layout wrap>
        <v-flex md4 sm6 xs12 offset-md8 offset-sm6>
          <v-card v-if="$user && $user.id">
            <v-card-title class="blue--text">Profile</v-card-title>
            <img :src="$user.avatar" style="height: 100px;" class="img-thumbnail img-circle">
            <p class="text-muted"><em>Change your avatar at <a href="http://gravatar.com" target="_blank" rel="noopener noreferrer">Gravatar.com</a></em></p>
            <v-card-text>
              <table class="table table-condensed">
                <tbody>
                  <tr>
                    <td>Name</td><td>{{ $user.name }}</td>
                  </tr>
                  <tr>
                    <td>Gender</td><td>{{ $user.gender }}</td>
                  </tr>
                  <tr>
                    <td>Email</td><td><i>{{ $user.email }}</i></td>
                  </tr>
                  <tr>
                    <td>Phone</td><td><i>{{ $user.phone }}</i></td>
                  </tr>
                  <tr>
                    <td>Residence</td><td>{{ $user.residence }}</td>
                  </tr>
                </tbody>
              </table>
            </v-card-text>
            <v-card-actions>
              <v-btn small @click="editprofile = !editprofile" class="pa-0 btn-danger">Edit</v-btn>
              <v-btn small @click="changePassword = !changePassword" class="pa-0 btn-danger">Change Password</v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
      <v-dialog :fullscreen="$breakpoint.xsOnly" v-model="editprofile">
        <v-card>
          <v-card-title class="blue-bg">
            <v-btn class="pa-0 mt-0" icon flat @click="editprofile = false" title="Close">
              <v-icon>fa-arrow-left</v-icon>
            </v-btn>
            <h4 class="text-center">Edit Profile</h4>
          </v-card-title>
          <v-card-text>
            <form @submit.prevent="saveProfile">
              <v-text-field label="Name" v-model="user.name" required></v-text-field>

              <v-select light autocomplete label="Gender" prepend-icon="fa-venus-mars" v-model="user.gender" :items="[{ text: 'Female', value: 'Female' }, { text: 'Male', value: 'Male'}, { text: 'Rather Not Say', value: 'Undefined' }]" clearable required open-on-clear name="Gender" data-vv-name="Gender"></v-select>

              <v-btn type="submit" small class="pa-0 btn-primary">Submit</v-btn>
            </form>
          </v-card-text>
          <v-card-actions>
            <v-btn class="pa-0" flat @click="editprofile = false" title="Close" v-if="!$breakpoint.xsOnly">Close</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="changePassword">
        <v-card>
          <v-card-title class="blue-bg white--text">
            <v-btn class="pa-0 mt-0" icon flat @click="changePassword = false" title="Close">
              <v-icon>fa-arrow-left</v-icon>
            </v-btn>
            <h4 class="text-center">Change Password</h4>
          </v-card-title>
          <v-card-text>
            <password></password>
          </v-card-text>
          <v-card-actions>
            <v-btn class="pa-0" flat @click="changePassword = false" title="Close" v-if="!$breakpoint.xsOnly">Close</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </transition>
</template>

<script>
  export default {
    name: 'UserProfile',
    components: {
      Password: require('./components/password.vue')
    },
    data () {
      return {
        editprofile: false,
        avatar: '',
        changePassword: false,
      }
    },
    methods: {
      fetchData () {
        this._getUser()
      },
      saveProfile () {
        swal({
          title: 'Updating',
          text: '<i class="fa fa-2x fa-spinner fa-pulse"></i>',
          type: 'warning',
          showCancelButton: false,
          showConfirmButton: false,
        })
        this.$http.put('users/' + this.user.id, this.user)
        .then(res => {
          this._getUser()
          swal({ title:'Updated', type:'success', timer:2000 })
        })
        .catch(err => {
          swal('Error '+err.status+': '+err.statusText, 'Failed to Update', 'error')
        })
      },
    },
    created () {
      this.fetchData()
    },
    computed: {
      user: {
        get () {
          return this.$store.getters['auth/user']
        },
        set (value) {
          this.$store.commit('auth/user', { user: value })
        }
      },
    },
    watch: {
      '$route': 'fetchData',
    }
  }
</script>

<style>
  p#earnings {
    font-size: xx-large;
    color: turquoise;
  }
</style>
