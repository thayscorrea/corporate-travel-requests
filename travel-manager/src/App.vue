<template>
  <div id="app">
    <AlertView v-if="alert.message" :type="alert.type" :message="alert.message" />

    <main>
      <router-view />
    </main>
  </div>
</template>

<script>
import AlertView from '@/components/AlertView.vue';
import { mapGetters } from 'vuex';

export default {
  name: 'App',
  components: {
    AlertView,
  },
  computed: {
    ...mapGetters(['alert']),
  },
};
</script>

<style scoped>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 20px;
}

main {
  padding: 20px;
}
</style>