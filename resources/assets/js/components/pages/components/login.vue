<template>
  <!-- <transition name=""> -->
    <v-container fluid>
      <div class="login">
        <div class="alert alert-danger" v-if="message">{{ message }}</div>
        <v-form v-model="valid" lazy-validation>
          <div class="form-group">
            <v-text-field label="Email" v-model="user.username" type="email" autofocus required :rules="[rules.required, rules.email]" placeholder="you@yourdomain.com" :error-messages="errors.collect('email')" data-vv-name="email" validate-on-blur></v-text-field>
          </div>
          <div class="form-group">
            <v-text-field name="Password" label="Password" hint="Enter your password" v-model="user.password" min="6" :append-icon="e1 ? 'visibility' : 'visibility_off'" :append-icon-cb="() => (e1 = !e1)" :type="e1 ? 'password' : 'text'" :rules="[rules.required]" required></v-text-field>
          </div>
          <!-- <recaptcha classes="btn btn--small btn-primary pa-0" type="submit" @verified="login(user)" @click="swal('Logging in ...')"></recaptcha> -->
          <v-btn small class="btn btn-default btn-block pa-0 white--text" type="submit" color="blue" :disabled="!valid" @click.prevent.stop="login(user)" :loading="logging">Login</v-btn>
          <a href="/password/reset">Forgot Password?</a>
        </v-form>
      </div>
    </v-container>
  <!-- </transition> -->
</template>

<script>
  var url = window.location.origin +'/oauth/token'
  var id = 2
  var secret = 'BP5DNlo3ybWgMLclBaMrCUPvwelFNRuLsaqbCVHG'
  export default {
    name: 'Login',
    metaInfo () {
      return {
        title: 'Login',
        titleTemplate: '%s | ' + this.$title
      }
    },
    data() {
      return {
        token: this.$store.getters.refresh,
        user: {
          grant_type: 'password',
          client_secret: secret,
          client_id: id,
          scope: '*',
          username: '',
          password: '',
        },
        logging: false,
        existingUser: {
          grant_type: 'refresh_token',
          client_secret: secret,
          refresh_token: this.$cookie.get('refresh_token'),
          client_id: id,
          scope: '',
        },
        redirecting: false,
        message: '',
        rules: {
          required: (value) => !!value || 'Required.',
          email: (value) => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || 'Invalid e-mail.'
          }
        },
        e1: true,
        valid: false,
      }
    },
    methods: {
      refreshUser() {
        if (!this.existingUser.refresh_token) {
          return
        }
        if (!this.authUser || !this.authUser.id) {
          return
        }
        swal({
          title: '<i class="fa fa-refresh fa-spin" aria-hidden="true"></i><span class="sr-only">Logging in...</span>',
          text: 'Enter Your email',
          type: 'prompt',
          inputType: 'email',
          inputPlaceholder: 'Enter your email',
          showCancelButton: true,
          confirmButtonColor: 'rgba(255,100,50,0.5)',
          confirmButtonText:'Confirm Login',
          showLoaderOnConfirm: true,
          closeOnConfirm: false,
          html: true
        },
        function(input){
          if (input !== this.authUser.email) {
            swal({title: 'Email mismatch.<br> Please enter your full credentials', timer: 5000})
            this.$cookie.delete('refresh_token')
            return
          }
          this.message = ''
          this.logging = true
          this.$http.post(url, this.existingUser)
          .then(response => {
            this.logging = false
            this.postprocessing(response.body)
          })
          .catch(err => {
            if (err.body.message) {
              this.message = err.body.message
            }
            this.logging = false
            swal('Error '+err.status+': '+err.statusText,'Failed to refresh token. Login with your credentials','error')
          })
        }.bind(this))
      },
      login(user) {
        this.message = ''
        this.$validator.validateAll()
        .then(() => {
          this.logging = true
          this.$http.post(url, user)
          .then(response => {
            this.logging = false
            this.postprocessing(response.data)
          })
          .catch(err => {
            if (err.data.message) {
              this.message = err.data.message
            }
            this.user.password = ''
            console.log(err)
            this.logging = false
            swal('Error '+err.status+': '+err.statusText,'Failed to Login','error')
          })
        })
        .catch(response => {
          swal('Error','Form contains errors','error')
        })
      },
      postprocessing(token) {
        this.$auth.setToken(token)
        swal({
          title: '',
          text:'Completing Logging In   <i class="fa fa-snowflake-o fa-spin" aria-hidden="true"></i><span class="sr-only">Logging in...</span>',
          showCancelButton:true,
          type: '',
          html: true,
          showConfirmButton: false,
          showCancelButton: false,
        })
        setTimeout(function() {
          this.getUser(token)
        }.bind(this), 200);
      },
      getUser(data) {
        this._getUser()
        .then(res => {
          this.$store.commit('auth/user', { user: res })
          if (! this.redirecting) {
            this.redirecting = true
            this.redirect()
          }
          // window.location.reload()
        })
        // this.$auth.setUser()
        // .then(response => {
        //   this.redirect()
        // })
      },
      redirect() {
        swal.close()
        if (!this.redirecting) {
          this.redirecting = true
          var redirect = this.$route.query.redirect
          redirect ? this.$router.push(redirect) : this.$router.push('/user')
        }
      },
      autologin () {
        if (this.$route.query.auto) {
          swal('Completing Logging you in ...')
          var userpass = this.$route.query.auto
          var pass = userpass.split(':')
          this.user.username = pass[0]
          this.user.password = pass[1]
          this.login(this.user)
          this.$route.query.redirect = '/assignments'
        }
      }
    },
    created() {
      // this.refreshUser()
      this.autologin()
      if (this.$route.query.redirect === '/login/user') {
        this.$router.push('/login?')
      }
      // if (process.env.NODE_ENV != 'production') {
      //   this.user.username = 'jarod.medhurst@example.org'
      //   this.user.password = 'Zxcvbnm123'
      // }
    },
    updated() {
      if (this.$auth.isAuthenticated() && this.$store.state.user.id) {
        this.redirect()
      }
    },
    computed: {
      authUser () {
        return this.$auth.getUser()
      },
      loggedInUser() {
        return this.$auth.getUser()
      }
    },
    watch: {
      'loggedInUser': function() {
        if (this.loggedInUser) {
          this.redirect()
        }
      },
      'e1': function () {
        if (!this.e1) {
          setTimeout(function() {
            this.e1 = true
          }.bind(this), 3000);
        }
      },
      '$token': function (val) {
        if (this.authUser.id) {
          // this.redirect()
        }
      }
    }
  }
</script>

<style>
  /**/
</style>
