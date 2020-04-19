<template>
  <transition name="slide-fade">
    <v-container fluid>
      <v-layout wrap>
        <v-flex xs12>
          <h3 class="text-center">Requests</h3>
        </v-flex>
        <v-flex xs12 class="px-2">
          <paginate name="access" :list="access" :per="n ? n : 10"></paginate>
          <table class="table table-responsive">
            <thead>
              <tr>
                <th style="max-width: 150px !important;">Request URL</th>
                <th><span style="visibility: hidden;">Usage by Percentage</span></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="log in paginated('access')" :key="log.url" class="">
                <td style="max-width: 150px !important;"><a :href="log.url" target="_blank">{{ log.url }}</a></td>
                <td style="padding: 0; border-top: 3px solid tomato;">
                  <div :style="{width: log.percentage + '%'}" class="percentile">
                    <span style="position: absolute; top: -25px; color: blue;">{{ log.percentage }}%</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <v-layout wrap>
            <v-flex xs8>
              <paginate-links for="access" :hide-single-page="false" :show-step-links="true" :limit="5" :async="true" class="list-inline text-center"></paginate-links>
            </v-flex>
            <v-flex xs4>
              <v-text-field v-model.number="n"></v-text-field>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>
<script>
  import _ from 'lodash'

  export default {
    name: 'UsersMetric',
    data () {
      return {
        paginate: ['access'],
        n: 10,
      }
    },
    methods: {
      //
    },
    created () {
      //
    },
    computed: {
      access_logs () {
        return this.$store.getters.access_logs
      },
      grouped () {
        return _.uniqBy(this.access_logs, 'url')
      },
      access () {
        var logs = this.access_logs
        var total = logs.length
        var groups = this.grouped
        var access = []

        for (let i = 0; i < groups.length; i++) {
          const element = groups[i];
          var acc = {}
          var leng = 0
          for (let j = 0; j < logs.length; j++) {
            if (element.url == logs[j].url) {
              leng = leng + 1
            }
            acc.percentage = parseFloat(((leng / total) * 100).toFixed(2))
          }
          acc.url = element.url
          access.push(acc)
        }
        var sorted = _.orderBy(access, 'percentage', 'desc')
        return sorted
      }
    },
    watch: {
      //
    }
  }
</script>
<style>
   .percentile {
     border-top: 16px solid red;
     position: relative;
   }
</style>
