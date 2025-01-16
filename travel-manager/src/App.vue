<template>
  <div id="app">
    <header>
      <nav>
        <ul>
          <li><router-link to="/">Login</router-link></li>
          <li><router-link to="/dashboard">Dashboard</router-link></li>
          <li><router-link to="/create-order">Create Order</router-link></li>
          <li><router-link to="/update-status">Update Status</router-link></li>
        </ul>
      </nav>
    </header>

    <main>
      <router-view />
    </main>
    <AlertView v-if="alert.message" :type="alert.type" :message="alert.message" />
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

header {
  background-color: #007bff;
  padding: 10px;
  color: white;
}

nav ul {
  list-style: none;
  display: flex;
  justify-content: center;
  padding: 0;
  margin: 0;
}

nav ul li {
  margin: 0 10px;
}

nav ul li a {
  color: white;
  text-decoration: none;
  font-weight: bold;
}

nav ul li a:hover {
  text-decoration: underline;
}

main {
  padding: 20px;
}
</style>