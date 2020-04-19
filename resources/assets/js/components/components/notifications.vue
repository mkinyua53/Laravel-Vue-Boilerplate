<template>
  <transition name="slide-fade">
    <v-container fluid>
      <title>Notifications</title>
      <v-layout wrap>
        <v-flex xs12>
          <h3 class="text-center">Notifications</h3>
        </v-flex>
        <v-flex xs12>
          <p>{{ database.length }} notifications found.</p>
          <p class="pull-right">
            <v-btn icon small flat @click="deleteNotifications" class="pa-0" title="Mark all as read">
              <v-icon>fa-check</v-icon>
            </v-btn>
          </p>
        </v-flex>
      </v-layout>
      <v-layout wrap v-if="database && database.length > 0">
        <v-flex xs12 md3 sm4 v-for="notify in database" :key="notify.id" style="">
          <v-card class="ma-1" :color="!notify.read_at ? 'grey lighten-2' : ''">
            <v-card-title style="margin: -15px 0 -30px 0;">{{ notify.type.replace('App\\Notifications\\', "") }}</v-card-title>
            <v-card-text>
              <p>{{ notify.data.message }}</p>
              <p v-if="notify.data.body">{{ notify.data.body }}</p>
              <p v-if="notify.data.from">FROM: {{ notify.data.from }}</p>
              <p v-if="notify.data.contract_id"><router-link :to="'/user/contracts/' + notify.data.contract_id">View</router-link></p>
              <p style="line-height: 0.5; margin-bottom: -5px; color: turquoise;" v-html="notify.created_at"></p>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>
<script>
  export default {
    name: 'Notifications',
    data () {
      return {
        data: '',
      }
    },
    methods: {
      getNotifications () {
         this._getNotifications()
      },
      deleteNotifications () {
        swal({
          title: 'Mark Notifications as read?',
          text: '',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: 'red',
          confirmButtonText:'Delete',
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function () {
          this._deleteNotifications()
          .then(res => {
            this.getNotifications()
            swal('Done')
          })
          .catch(err => {
            swal({ title: 'Failed', type: 'error' })
            this.getNotifications()
          })
        }.bind(this))
      }
    },
    created () {
      this.getNotifications()
    },
    computed: {
      database () {
        return this.$store.getters['notifications/database']
      }
    },
    watch: {
      //
    }
  }
</script>
<style>
   /**/
</style>
