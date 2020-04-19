<template>
  <transition name="slide-fade">
    <v-container fluid>
      <title>Metrics | {{ $title }}</title>
      <v-layout wrap>
        <v-flex xs12>
          <h3 class="text-center">Metrics</h3>
        </v-flex>
      </v-layout>
      <v-layout wrap v-if="logs.length > 0">
        <v-flex xs12 class="">
          <user class=""></user>
        </v-flex>
        <v-flex xs12>
          <page></page>
        </v-flex>
        <!-- <v-flex xs12>
          <refferer></refferer>
        </v-flex> -->
      </v-layout>
    </v-container>
  </transition>
</template>
<script>
  export default {
    name: 'Metrics',
    components: {
      user: require('./metrics/user.vue'),
      page: require('./metrics/page.vue'),
      // refferer: require('./metrics/path.vue')
    },
    data () {
      return {
        data: '',
      }
    },
    methods: {
      fetchData () {
         this.$http.get('access_logs')
         .then(res => {
           this.$store.commit('access_logs', { access_logs: res.body })
         })
         .catch(err => {
           swal('Error '+err.status+': '+err.statusText,'Failed to load logs','error')
         })
      }
    },
    created () {
      this.fetchData()
    },
    computed: {
      logs () {
        return this.$store.getters.access_logs
      }
    },
    watch: {
      '$route': 'fetchData',
    }
  }
</script>
<style>
   /**/
</style>
