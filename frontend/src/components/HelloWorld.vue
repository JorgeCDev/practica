<template>
  <v-container>
    <v-row justify="center">
      <v-col class="mt-14" cols="10" align-self="center"> <main-view /></v-col>
    </v-row>
  </v-container>
</template>

<script>
import MainView from "./MainView.vue";
export default {
  name: "HelloWorld",
  components: {
    "main-view": MainView,
  },

  data: () => ({}),
};
</script>
