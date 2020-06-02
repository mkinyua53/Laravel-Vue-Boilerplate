<template>
  <transition name="bounce">
    <div>
      <v-layout wrap>
        <v-flex xs10 offset-xs1 md6 offset-md3 sm6 offset-sm3>
          <v-card class="elevation-12">
            <v-card-text>
              <form @submit.prevent="checkPassword">
                <div class="form-group">
                  <label for="old_password">Current Password</label>
                  <input type="password" name="Old Password" class="form-control" id="old-password" v-model="password.old_password" v-validate="'required'" required minlength="6" autocomplete="off">
                  <span class="help-block" v-show="errors.has('Old Password')">
                    {{ errors.first('Old Password') }}
                  </span>
                </div>
                <div class="form-group">
                  <label for="password">New Password</label>
                  <input type="password" name="Password" class="form-control" id="password" v-model="password.password" v-validate="'required|min:6'" required minlength="8">
                  <span class="help-block" v-show="errors.has('Password')">
                    {{ errors.first('Password') }}
                  </span>
                </div>
                <div class="form-group">
                  <label for="password_confirmation">Confirm Password</label>
                  <input type="password" name="Confirm Password" class="form-control" id="password_confirmation" v-model="password.password_confirmation" v-validate="'confirmed:Password|required'" required minlength="8">
                  <span class="help-block" v-show="errors.has('Confirm Password')">
                    {{ errors.first('Confirm Password') }}
                  </span>
                </div>
                <button class="btn btn-primary btn-block" type="submit" v-ripple>
                  Submit<span v-if="saving">ting...</span>
                </button>
              </form>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </div>
  </transition>
</template>

<script>
  var url = window.location.origin + '/oauth/token'
  var id = 2
  var secret = 'BP5DNlo3ybWgMLclBaMrCUPvwelFNRuLsaqbCVHG'
  export default {
    name: 'PasswordChange',
    data() {
      return {
        password: {
          old_password: '',
          password: '',
          password_confirmation: ''
        },
        saving: false
      }
    },
    methods: {
      changePassword(password) {
        this.saving = true
        this.$http.post('password-change',password)
        .then(response => {
          this.saving = false
          swal({title:'Password Changed',type:'success'})
          this.password = {}
        })
        .catch(err => {
          this.saving = false
          swal('Error '+err.status+': '+err.statusText,'Failed to Change Password!','error')
          this.password = {}
        })
      },
      checkPassword() {
        this.$validator.validateAll()
        .then(() => {
          swal({
            title:'Checking Password',
            text:'<i class="fa fa-pulse fa-spinner">',
            html:true
          })
          this.$http.post(url, {
            grant_type: 'password',
            client_secret: secret,
            client_id: id,
            scope: '*',
            username: this.$user.email,
            password: this.password.old_password,
          })
          .then(() => {
            swal({
              title:'Changing Password',
              text:'<i class="fa fa-pulse fa-spinner">',
              html:true
            })
            this.changePassword(this.password)
          })
          .catch(err => {
            swal('Error '+err.status+': '+err.statusText,'We could not verify your credentials. Check your inputs','error')
          })
        })
        .catch(response => {
          swal('Form Error','Check Form','error')
        })
      }
    }
  }
</script>

<style>
  /**/
</style>
