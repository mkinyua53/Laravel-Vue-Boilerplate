<template>
  <transition name="">
    <v-container fluid class="mb-5">
      <v-layout wrap>
        <v-flex xs10 md6 sm8 offset-md3 offset-sm2 offset-xs1 class="mb-5">
          <p id="empasized">Use this dashboard to manage your resources</p>
          <v-card class="elevation-12">
            <v-card-title class="grey">Available tools</v-card-title>
            <v-card-text class="px-5">
              <h1 class="text-center">Dashboard</h1>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>

<script>
  export default {
    name: 'DashBoard',
    metaInfo () {
      return {
        title: 'DashBoard',
        titleTemplate: '%s | ' + this.$title
      }
    },
    data () {
      return {
        details: {
          product: ''
        },
      }
    },
    methods: {
      //
    },
    created () {
      //
    },
    computed: {
      //
    },
    watch: {
      //
    }
  }
</script>

<style>
  .crazy {
    box-shadow: 0 0 10px;
    font-size: x-large;
    padding: 10px;
    margin: 10px;
    /* background-color: aliceblue; */
  }
  #board {
    margin: 10px;
    padding: 1px;
    box-shadow: 1px 1px 10px;
    /* background: aliceblue; */
  }
</style>
