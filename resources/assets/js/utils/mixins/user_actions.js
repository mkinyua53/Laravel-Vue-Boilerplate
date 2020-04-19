export default {
  data () {
    return {
      // fetching: true
    }
  },
  methods: {
    //
  },
  computed: {
    $user () {
      return this.$store.getters['auth/user']
    },
  },
  watch: {
    '$user': function (value) {
      if (value) {
        //
      }
    }
  }
}
