<template>
  <transition name="slide-fade">
    <v-container fluid>
      <title>Feedback</title>
      <v-layout wrap>
        <v-flex xs12>
          <h3 class="text-center">Feedback</h3>
        </v-flex>
      </v-layout>
      <v-layout wrap>
        <v-flex xs12>
          <v-text-field label="Search" v-model="filterBy" prepend-icon="search" :disabled="feedback.length < 1" :append-icon="filterBy.length > 0 ? 'close' : ''" :append-icon-cb="() => (filterBy = '')"></v-text-field>
        </v-flex>
        <v-flex xs12>
          <v-card>
            <v-card-text>
              <v-data-table :headers="headers" :items="feedback" no-data-text="No records found!" disable-initial-sort :search="filterBy">
                <template slot="items" slot-scope="props">
                  <td>{{ props.item.name }}</td>
                  <td>{{ props.item.email }}</td>
                  <td>{{ props.item.subject }}</td>
                  <td @click="viewMessage(props.item)" role="button">
                    <v-icon>{{ props.item.resolved ? 'fa-check-square-o' : 'fa-square-o' }}</v-icon>
                  </td>
                  <td>{{ props.item.created_at }}</td>
                  <td>
                    <v-btn flat small icon @click="viewMessage(props.item)" class="pa-0">
                      <v-icon>fa-eye</v-icon>
                    </v-btn>
                  </td>
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
      <v-dialog v-model="view" :fullscreen="$breakpoint.xsOnly">
        <v-card>
          <v-card-title class="teal white--text">
            <v-btn class="pa-0 mt-0" icon flat @click="view = false" title="Close">
              <v-icon>fa-arrow-left</v-icon>
            </v-btn>
            <h4 class="text-center">View Message</h4>
          </v-card-title>
          <v-card-text v-if="message.id">
            <p>From: {{ message.name }} {{ message.email }}</p>
            <p>Subject: {{ message.subject }}</p>
            <p v-html="message.message"></p>
            <p>
              <v-btn small @click="resolve(message)" class="pa-0 btn-warning">
                {{ message.resolved ? 'Unresolve' : 'Resolve' }}
              </v-btn>
            </p>
          </v-card-text>
          <v-card-actions>
            <v-btn class="pa-0" flat @click="view = false" title="Close">Close</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </transition>
</template>
<script>
  export default {
    name: 'Feedback',
    data () {
      return {
        paginate: ['filtered'],
        view: false,
        headers: [
          { text: 'Name', value: 'name' },
          { text: 'Email', value: 'email' },
          { text: 'Subject', value: 'subject' },
          { text: 'Resolved', value: 'resolved' },
          { text: 'Created', value: 'created_at' },
          { text: '', value: '', sortable: false, align: 'left', width: '26px' }
        ]
      }
    },
    methods: {
      fetchData () {
         this._getFeedback()
      },
      viewMessage (message) {
        this.$store.commit('feedback/message', { message })
        this.view = true
      },
      resolve (message) {
        if (message.resolved) {
          message.resolved = null
        }
        else {
          message.resolved = Date().toString()
        }
        swal({ title: '', text: 'Working ....'})
        this.$http.put('feedback/' + message.id, message)
        .then(res => {
          this.fetchData()
          swal({ title: 'Saved', type: 'success', timer: 5000 })
        })
        .catch(err => {
          swal('Error '+err.status+': '+err.statusText,'Failed to Update','error')
        })
      }
    },
    created () {
      this.fetchData()
    },
    computed: {
      filterBy: {
        get () {
          return this.$store.getters['feedback/filterBy']
        },
        set (filterBy) {
          this.$store.commit('feedback/filterBy', { filterBy })
        }
      },
      feedback () {
        return this.$store.getters['feedback/feedback']
      },
      message: {
        get () {
          return this.$store.getters['feedback/message']
        },
        set (message) {
          this.$store.commit('feedback/message', { message })
        }
      },
      filtered () {
        return this.feedback.filter((message) => {
          return message.string.toLowerCase().includes(this.filterBy.toLowerCase())
        })
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
