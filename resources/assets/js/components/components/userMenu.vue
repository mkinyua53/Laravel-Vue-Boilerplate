<template>
  <v-list dark class="blue darken-4">
    <v-list-tile avatar to="/user">
      <v-list-tile-avatar>
        <v-icon>fa-user</v-icon>
      </v-list-tile-avatar>
      <v-list-tile-content>
        <v-list-tile-title>Profile</v-list-tile-title>
        <v-list-tile-sub-title>View my profile</v-list-tile-sub-title>
      </v-list-tile-content>
    </v-list-tile>
    <v-divider></v-divider>
    <v-list-tile avatar to="/logout" v-if="$auth.isAuthenticated()">
      <v-list-tile-avatar>
        <v-icon>fa-sign-out</v-icon>
      </v-list-tile-avatar>
      <v-list-tile-content>
        <v-list-tile-title>Log Out</v-list-tile-title>
        <v-list-tile-sub-title>Log out of the system</v-list-tile-sub-title>
      </v-list-tile-content>
    </v-list-tile>
    <v-list-tile avatar to="/login" v-else>
      <v-list-tile-avatar>
        <v-icon>fa-sign-in</v-icon>
      </v-list-tile-avatar>
      <v-list-tile-content>
        <v-list-tile-title>Log In</v-list-tile-title>
        <v-list-tile-sub-title>Log In</v-list-tile-sub-title>
      </v-list-tile-content>
    </v-list-tile>
  </v-list>
</template>
