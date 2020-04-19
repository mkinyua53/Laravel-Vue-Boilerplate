<template>
  <transition name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
    <v-container fluid id="body">
      <title>Register | Inflab Global</title>
      <div class="panel panel-default pa-1">
        <div class="panel-body">
          <form @submit.prevent="RegisterUser" ref="form">
            <v-text-field name="First Name" label="First Name" v-model="first_name" :append-icon="first_name.length > 0 ? 'close' : ''" :append-icon-cb="() => (first_name = '')" :rules="[rules.required]" :error-messages="errors.collect('First Name')" required></v-text-field>

            <v-text-field label="Last Name" name="Last Name" v-model="second_name" :append-icon="second_name.length > 0 ? 'close' : ''" :append-icon-cb="() => (second_name = '')" :rules="[rules.required]" :error-messages="errors.collect('Last Name')" required></v-text-field>
            <input type="hidden" v-model="user.name">

            <v-text-field label="Email" name="Email" v-model="user.email" :append-icon="user.email && user.email.length > 0 ? 'close' : ''" :append-icon-cb="() => (email = '')" type="email" :rules="[rules.required, rules.email]" required></v-text-field>

            <v-select light label="Country" name="Country" v-model="user.country_id" :items="countries" item-text="name" item-value="id" autocomplete required :rules="[rules.required]" :error-messages="errors.collect('Country')"></v-select>

            <v-text-field :label="callingCode" name="Phone" hint="Enter Your Phone Number" v-model="user.phone" :append-icon="user.phone && user.phone.length > 0 ? 'close' : ''" :append-icon-cb="() => (user.phone = '')" required :rules="[rules.required]" :error-messages="errors.collect('Phone')"></v-text-field>

            <v-select light autocomplete label="Gender" v-model="user.gender" :items="[{ text: 'Female', value: 'Female' }, { text: 'Male', value: 'Male'}, { text: 'Rather Not Say', value: 'Undefined' }]" clearable required open-on-clear name="Gender" data-vv-name="Gender" :rules="[rules.required]" :errror-messages="errors.collect('Gender')"></v-select>

            <v-text-field name="Password" label="Password" hint="The password must be atleast 8 characters long and contain atleast one lowercase letter, one uppercase letter and one number" placeholder="aB3?5Fg!" v-model="user.password" min="8" :append-icon="e1 ? 'visibility' : 'visibility_off'" :append-icon-cb="() => (e1 = !e1)" :type="e1 ? 'password' : 'text'" required  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="60" data-vv-name="Password" :rules="[rules.required, rules.password]" :error-messages="errors.collect('Password')"></v-text-field>

            <ul v-for="error in validatorError" class="bg-info list-unstyled" :key="error.toString()">
              <li class="text-danger">{{ error }}</li>
            </ul>
            <recaptcha classes="pa-0 btn-primary btn--small"></recaptcha>
            <v-btn :loading="loading" :disabled="!valid" @click="RegisterUser" class="btn-primary btn-block">Register</v-btn>
          </form>
        </div>
      </div>
    </v-container>
  </transition>
</template>

<script>
  export default {
    name: 'Register',
    components: {
      Register: require('../users/register.vue')
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
