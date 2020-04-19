<template>
  <transition name="">
    <v-container fluid>
      <v-layout wrap>
        <v-flex md12 xs12 sm12>
          <!-- <h3 class="text-center"></h3> -->
          <div>
            <v-toolbar color="cyan" dark tabs>
              <v-toolbar-title>How it Works</v-toolbar-title>
              <v-tabs centered color="cyan" slot="extension" slider-color="yellow" v-model="model" prev-icon="fa-hand-o-left" next-icon="fa-hand-o-right">
                <v-tab v-for="(item, key) in items" :key="key" :href="`#tab-${key}`">Step {{ items.indexOf(item) + 1 }}</v-tab>
              </v-tabs>
            </v-toolbar>
            <v-tabs-items v-model="model">
              <v-tab-item v-for="(item, key) in items" :key="key" :id="`tab-${key}`">
                <v-card flat dark>
                  <v-card-title><h2 class="text-center">{{ item.name }}</h2></v-card-title>
                  <v-card-text><h3 v-html="item.text"></h3></v-card-text>
                </v-card>
              </v-tab-item>
            </v-tabs-items>
          </div>
        </v-flex>
      </v-layout>
    </v-container>
  </transition>
</template>

<script>
  export default {
    name: 'Procedure',
    data () {
      return {
        model: '',
        items: [
          {
            title: 'Step 1',
            name: 'Account',
            text: 'Log-in to your account, or <a href="#/register">register</a> for one; it\'s <span class="red--text hidden-xs" style="font-size: larger; transform: rotate(-20deg); position: absolute; text-shadow: 2px 2px 1px darkgoldenrod; margin-left: 5px; margin-top: -15px;">FREE!</span><span class="visible-xs red--text" style="font-size: larger; text-shadow: 2px 2px 1px darkgoldenrod; margin-left: 5px;">FREE</span>'
          },
          {
            title: 'Step 2',
            name: 'Add Resource',
            text: 'Add your resource as a influencer or entreprenuer.'
          },
          {
            title: 'Step 3',
            name: 'Influencer',
            text: 'As an influencer, add the media you use. It can be any social media, provided you claim a sizeable following/audience.'
          },
          {
            title: 'Step 4',
            name: 'Entreprenuer',
            text: 'As an entreprenuer, add the link to your online market(s).'
          },
          {
            title: 'Step 5',
            name: 'Link up',
            text: 'Find a suitable influencer who can market your product(s), get down to business and draft a contract.'
          },
          {
            title: 'Step 6',
            name: 'Pay',
            text: 'The entreprenuer will then pay the agreed upon amount according to the contract. The money will be held in an escrow account and be paid to the influencer when the terms of the contracts has been followed.'
          }
        ],
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
  /**/
</style>
