<template>
  <transition name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
    <v-container fluid id="body">
      <div class="pa-1 ma-1">
        <div class="">
          <form @submit.prevent="RegisterUser" ref="form" aria-autocomplete="off" autocomplete="off">
            <v-layout wrap>
              <v-flex xs6>
                <v-text-field name="First Name" label="First Name" v-model="first_name" :append-icon="first_name.length > 0 ? 'close' : ''" :append-icon-cb="() => (first_name = '')" :rules="[rules.required]" :error-messages="errors.collect('First Name')" required></v-text-field>
              </v-flex>
              <v-flex xs6>
                <v-text-field label="Last Name" name="Last Name" v-model="second_name" :append-icon="second_name.length > 0 ? 'close' : ''" :append-icon-cb="() => (second_name = '')" :rules="[rules.required]" :error-messages="errors.collect('Last Name')" required></v-text-field>
              </v-flex>
            </v-layout>

            <input type="hidden" v-model="user.name">

            <v-layout wrao>
              <v-flex xs6>
                <v-select light autocomplete label="Gender" v-model="user.gender" :items="[{ text: 'Female', value: 'Female' }, { text: 'Male', value: 'Male'}, { text: 'Rather Not Say', value: 'Undefined' }]" prepend-icon="fa-intersex" clearable required open-on-clear name="Gender" data-vv-name="Gender" :rules="[rules.required]" :errror-messages="errors.collect('Gender')"></v-select>
              </v-flex>
            </v-layout>

            <v-text-field label="Email" name="Email" v-model="user.email" :append-icon="user.email && user.email.length > 0 ? 'close' : ''" :append-icon-cb="() => (email = '')" type="email" :rules="[rules.required, rules.email]" required></v-text-field>



            <v-text-field label="Phone" prepend-icon="phone" name="Phone" hint="Enter Your Phone Number" v-model="user.phone" :append-icon="user.phone && user.phone.length > 0 ? 'close' : ''" :append-icon-cb="() => (user.phone = '')" required :rules="[rules.required]" :error-messages="errors.collect('Phone')"></v-text-field>

            <v-text-field name="Password" label="Password" hint="The password must be atleast 8 characters long and contain atleast one lowercase letter, one uppercase letter and one number" placeholder="aB3?5Fg!" v-model="user.password" min="8" :append-icon="e1 ? 'visibility' : 'visibility_off'" :append-icon-cb="() => (e1 = !e1)" :type="e1 ? 'password' : 'text'" required  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="60" data-vv-name="Password" :rules="[rules.required, rules.password]" :error-messages="errors.collect('Password')"></v-text-field>

            <label>
              <input type="checkbox" v-model="user.terms" required>
              Accept <a target="_blank" href="/terms">Terms of Use</a>
            </label><br>

            <ul v-for="error in validatorError" class="bg-info list-unstyled" :key="error">
              <li class="text-danger">{{ error }}</li>
            </ul>
            <!-- <recaptcha classes="pa-0 btn-primary btn--small btn" type="submit" @verified="RegisterUser"></recaptcha> -->
            <v-btn :loading="loading" :disabled="!valid" @click="RegisterUser" color="primary" class="pa-0">Register</v-btn>
          </form>
        </div>
      </div>
    </v-container>
  </transition>
</template>

<script>
  import _ from 'lodash'

  export default {
    name: 'Register',
    data () {
      return {
        user: {},
        first_name: '',
        second_name: '',
        e1: true,
        error: [],
        rules: {
          required: (value) => !!value || 'This field is required.',
          email: (value) => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || 'Please enter a valid e-mail.'
          },
          password: (value) => {
            const pattern2 = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/
            return pattern2.test(value) || 'Password pattern does not match the requested format'
          }
        },
        valid: true,
        loading: false,
        validatorError: []
      }
    },
    methods: {
      fetchData() {
        // this._getCountries()
      },
      RegisterUser () {
        this.validatorError.length = 0
        this.loading = true
        this.$http.post('users', this.user)
        .then(res => {
          swal('User Registered')
          this.loading = false
          this.$router.push('/login')
        })
        .catch(err => {
          if (err.status == 422) {
            var errors = err.body.errors
            var self = this
            _.forEach(errors, function (value, key) {
              self.validatorError.push(value[0])
            })
            console.log(this.validatorError)
          }
          this.loading = false
          swal('Error '+err.response.status+': '+err.response.statusText,'Failed to Register','error')
        })
      }
    },
    created () {
      this.fetchData()
    },
    computed: {
      countries () {
        return this.$store.getters.countries
      },
      callingCode () {
        var self = this
        var country = _.find(self.countries, function (c) {
          return c.id === self.user.country_id
        })
        return country ? '+' + country.phonecode : ''
      },
      name () {
        return this.first_name + ' ' + this.second_name
      }
    },
    watch: {
      'name': function (val) {
        return this.user.name = val
      },
      'e1': function (val) {
        if (!val) {
          setTimeout(function() {
            this.e1 = true
          }.bind(this), 2000);
        }
      },
      'user.country_id': function () {
        this.user.phone = this.callingCode + this.user.phone
      },
      'user.password': function (value) {
        this.user.password_confirmation = value
      }
    }
  }
</script>

<style>
  #body {
    background-image: url('/img/header-bg.jpg');
    background-attachment: fixed;
    background-size: cover;
  }
</style>
