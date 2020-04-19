<template>
  <transition name="">
    <v-container fluid>
      <title>User Profile | {{ user.name }} | {{ $store.state.title }}</title>
      <v-layout wrap>
        <v-flex md4 sm4 xs12>
          <img :src="user.avatar" style="height: 100px;" class="img-thumbnail img-circle">
        </v-flex>
        <v-flex md4 sm8 xs12>
          <v-card v-if="user && user.id">
            <v-card-title class="blue--text">Profile</v-card-title>
            <v-card-text>
              <table class="table table-condensed">
                <tbody>
                  <tr>
                    <td>Name</td><td>{{ user.name }}</td>
                  </tr>
                  <tr>
                    <td>Gender</td><td>{{ user.gender }}</td>
                  </tr>
                  <tr>
                    <td>Email</td><td><i>{{ user.email }}</i></td>
                  </tr>
                  <tr>
                    <td>Phone</td><td><i>{{ user.phone }}</i></td>
                  </tr>
                  <tr>
                    <td>Residence</td><td>{{ user.residence }}</td>
                  </tr>
                </tbody>
              </table>
            </v-card-text>
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
            <!--  -->
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
            <!--  -->
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
      //
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
        this._getSelectedUser(this.$route.params.user)
      },
    },
    created () {
      this.fetchData()
    },
    computed: {
      user: {
        get () {
          return this.$store.getters['users/user']
        },
        set (value) {
          this.$store.commit('users/user', { user: value })
        }
      },
    },
    watch: {
      //
    }
  }
</script>

<style>
  @media (min-width: 501px) {
    .bordered-left {
      border-left: 1px solid grey;
    }
  }
</style>
