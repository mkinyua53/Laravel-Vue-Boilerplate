<template>
	<transition name="bounce">
		<div class="panel panel-danger">
			<div class="panel-heading" @click="shown = !shown">
				<a>Change Password</a>
				<span class="pull-right">
					<i class="fa fa-arrow-down" v-if="! shown" aria-hidden="true"></i>
					<i class="fa fa-arrow-up" v-if="shown" aria-hidden="true"></i>
					<span class="sr-only">Hide/Show action panel</span>
				</span>
			</div>
			<div class="panel-body">
				<transition-group name="custom-classes-transition" enter-active-class="animated zoomInUp" leave-active-class="animated zoomOutDown">
					<form @submit.prevent="checkPassword" v-if="shown" :key="'password'" class="ma-2">
						<div class="form-group">
							<label for="old_password">Current Password</label>
							<input type="password" name="Old Password" class="form-control" id="old-password" v-model="password.old_password" v-validate="'required'" required minlength="6">
							<span class="help-block" v-show="errors.has('Old Password')">
								{{ errors.first('Old Password') }}
							</span>
						</div>

						<v-text-field name="Password" label="Password" hint="The password must be atleast 8 characters long and contain atleast one lowercase letter, one uppercase letter and one number" placeholder="aB3?5Fg!" v-model="password.password" min="8" :append-icon="e1 ? 'visibility' : 'visibility_off'" :append-icon-cb="() => (e1 = !e1)" :type="e1 ? 'password' : 'text'" required  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="60" data-vv-name="Password" :rules="[rules.required, rules.password]" :errror-messages="errors.collect('Password')"></v-text-field>

						<v-text-field name="ConfirmPassword" label="Confirm Password" hint="The password must be atleast 8 characters long and contain atleast one lowercase letter, one uppercase letter and one number" placeholder="aB3?5Fg!" v-model="password.password_confirmation" min="8" :append-icon="e1 ? 'visibility' : 'visibility_off'" :append-icon-cb="() => (e1 = !e1)" :type="e1 ? 'password' : 'text'" required  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="60" data-vv-name="ConfirmPassword" :rules="[rules.required, rules.password, rules.confirmed]" :errror-messages="errors.collect('Password')"></v-text-field>

						<div class="form-group" v-if="error.password">
							<span class="text-danger">{{ error.password[0] }}</span>
						</div>
						<button class="btn btn-primary btn-block" type="submit">
							Submit<span v-if="saving">ting...</span>
						</button>
					</form>
				</transition-group>
			</div>
		</div>
	</transition>
</template>

<script>
	var url = window.location.origin +'/oauth/token'
	var id = 2
	var secret = 'ZywnNMA1XjVgErJnqQKeaKzT5gEfx3jyhmkr7qrp'
	export default {
		name: 'PasswordChange',
		props: ['user'],
		data() {
			return {
				shown: false,
				password: {
					old_password: '',
					password: '',
					password_confirmation: ''
				},
				saving: false,
				error: [],
				e1: true,
				rules: {
          required: (value) => !!value || 'This field is required.',
          email: (value) => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || 'Please enter a valid e-mail.'
          },
          password: (value) => {
          	const pattern2 = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/
          	return pattern2.test(value) || 'Password pattern does not match the requested format'
          },
          confirmed: (v1) => {
            var v2 = this.user.password
            return v1 === v2 || "The Value don't match."
          }
        },
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
					this.password = {},
					this.error = err.body
				})
			},
			checkPassword() {
				var username = this.user.email
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
						username: username,
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
		},
		watch: {
			'e1': function () {
				if (!this.e1) {
					setTimeout(function() {
						this.e1 = true
					}.bind(this), 5000);
				}
			}
		}
	}
</script>

<style>
	/**/
</style>
