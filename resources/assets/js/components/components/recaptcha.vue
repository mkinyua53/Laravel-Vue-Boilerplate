<template>
  <vue-recaptcha sitekey="6LfL4bkUAAAAAD2_ibIWQ-4MEEaETnYy6SRs8vAy" :loadRecaptchaScript="true" @verify="onVerify" @expired="onExpired" ref="recaptcha" :ripple="true">
    <button :class="classes" :type="type" @click.prevent="working">Submit</button>
  </vue-recaptcha>
</template>

<script>
  import VueRecaptcha from 'vue-recaptcha';
  export default {
    components: { VueRecaptcha },
    props: [
      'classes', 'type'
    ],
    methods: {
      onSubmit: function () {
        this.$refs.invisibleRecaptcha.execute()
      },
      onVerify: function (response) {
        this.$emit('verified')
        this.resetRecaptcha()
        // console.log('Verify: ' + response)
      },
      onExpired: function () {
        this.resetRecaptcha()
        console.log('Expired')
      },
      resetRecaptcha () {
        this.$refs.recaptcha.reset() // Direct call reset method
      },
      working () {
        swal({text: 'Please wait ...', title: '', showConfirmButton: false, showCancelButton: false })
      }
    }
  }
</script>
