<template>
  <transition name="slide-fade">
    <v-container fluid>
      <v-layout wrap>
        <v-flex xs12>
          <router-view v-if="user.id"></router-view>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>
<script>
  export default {
    name: 'UserIndex',
    data () {
      return {
        data: '',
      }
    },
    methods: {
      fetchData () {
        this._getUser(this.$route.params.user)
      }
    },
    created () {
      this.fetchData()
    },
    computed: {
      user () {
        return this.$store.getters['users/user']
      }
    },
    watch: {
      '$route.params.user': 'fetchData',
    }
  }
</script>
<style>
   /**/
</style>
