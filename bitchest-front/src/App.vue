<template>
<Pictos />

<router-view />
</template>

<script>
import Pictos from './components/Pictos.vue'

export default {
  name: 'App',
  components: {
    Pictos
  },
  methods: {
      isLoggedIn() {

      }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
body {
  position: relative;
}
aside {
  position: sticky;
  top: 0;
  width: 100%;
  height: 100vh;
  min-width: 200px;
}
</style>
