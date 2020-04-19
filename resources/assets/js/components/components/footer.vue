<template>
  <v-footer dark>
    <v-container fluid>
      <v-layout wrap>
        <v-flex md6 sm6 xs12 id="links">
          <h2 class="shadowed text-center">Influnet Global</h2>
          <ul class="list-unstyled">
            <li><v-icon color="green">home</v-icon> <a href="/#home">Home</a></li>
            <li><v-icon color="green">assignment</v-icon> <router-link to="/privacy">Privacy Policy</router-link></li>
            <li><v-icon color="green">assignment</v-icon> <router-link to="/terms">Terms of Use</router-link></li>
            <li><v-icon color="green">inbox</v-icon> <a href="/#contactus">Contact Us</a></li>
            <li><v-icon color="green">star</v-icon> <a href="/#pricing">Pricing</a></li>
            <li><v-icon color="green">star</v-icon> <a href="/#howitworks">How It Works</a></li>
          </ul>
        </v-flex>
        <v-flex md6 sm6 xs12>
          <h2 class="shadowed text-center">Contact Us</h2>
          <p><v-icon color="green">phone</v-icon> +254 729 744 787</p>
          <p><v-icon color="green">email</v-icon> <a @click="openEmailClient">influnetglobal<code class="monospaced">[&#64;]</code>hynnexholdings.co.ke</a></p>
        </v-flex>
      </v-layout>
      <v-layout wrap>
        <v-flex sm6 md6 xs12>
          <ul class="list-inline social">
            <li>Connect with us on</li>
            <li><a href="https://twitter.com/InflunetGlobal" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li><a href="/#" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="/#" target="_blank"><i class="fa fa-instagram"></i></a></li>
          </ul>
        </v-flex>
        <v-flex sm6 md6 xs12>
          <p class="text-center"><small>&copy; 2019 - {{ getYear() }} Hynnex Holdings. All rights reserved. <br>
            <!-- Created by <a href="http://visualsoldiers.com">Visual Soldiers</a> --></small></p>
        </v-flex>
        <v-flex xs12>
          <hr class="yellow" style="margin: 20px 100px auto;">
        </v-flex>
      </v-layout>
    </v-container>
  </v-footer>
</template>

<script>
export default {
  name: 'AppFooter',
  methods: {
    getYear () {
      var d = new Date()
      return d.getFullYear()
    },
    openEmailClient () {
      var subject = prompt('What would you like to tell us?', '')

      if (!subject || subject.length < 3) {
        return
      }
      window.open('mailto:influnetglobal@hynnexholdings.co.ke?subject=' + subject, '_blank')
    }
  }
}
</script>

<style scoped>
  /* @media (min-width: 600px) {
    #links {
      border-right: 1px solid yellow;
    }
  } */
  code {
    background: none;
  }
</style>
