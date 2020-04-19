<template>
	<div class="media">
		<div class="media-left">
			<a><img :src="user.avatar" :alt="user.name+' avatar'" class="img-circle media-object" style="width: 145px; height: 145px; float: left;"></a>
		</div>
		<div class="media-body noprint hidden">
			<form enctype="multipart/form-data" @submit.prevent="submitAvatar" id="form-avatar">
				<div class="form-group">
					<label>Change Photo</label>
					<input type="file" name="avatar" @change="uploadedAvatar" id="avatar"  v-validate="'required|image|size:2048'" required>
					<span class="help-block" v-show="errors.has('avatar')">{{errors.first('avatar')}}</span>
				</div>
				<v-btn type="submit" small :loading="uploading" class="btn-primary pa-0" :disabled="errors.has('avatar')">Upload</v-btn>
			</form>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'avatar',
		props: ['user'],
		data() {
			return {
				uploading: false,
			}
		},
		methods: {
			uploadedAvatar(e) {
				this.$validator.validateAll()
				.then(() => {
					var fileReader = new FileReader()
					fileReader.readAsDataURL(e.target.files[0])
					fileReader.onload = (e) => {
						this.avatar = e.target.result
					}
				})
				.catch(response => {
					swal('Error','Only an Image, less than 2Mb is accepted','error')
				})
				// this.avatar = $('#avatar').val()
			},
			submitAvatar() {
				this.$validator.validateAll()
				.then(() => {
					this.uploading = true
					this.$http.post('users/'+this.user.id+'/avatar',{avatar:this.avatar})
					.then(response => {
						this.uploading = false
						this.user.avatar = response.body
						this.$store.commit('user',{user:this.user})
					})
					.catch(err => {
						swal('Error '+err.status+': '+err.statusText,'Failed to Save the Avatar!','error')
						this.uploading = false
					})
					.bind(this)
				})
				.catch(response => {
					swal('Error: Either not an image or more than 2Mb or both!')
				})
			}
		}
	}
</script>

<style>
	/**/
</style>
