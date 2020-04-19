<template>
  <transition name="slide-fade">
    <v-container fluid>
      <transition name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut" mode="out-in">
        <router-view :key="$route.fullPath"></router-view>
      </transition>
    </v-container>
  </transition>
</template>

<script>
  export default {
    name: 'Create',
  }
</script>

<style>
   /**/
</style>
