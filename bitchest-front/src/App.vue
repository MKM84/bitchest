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
</style>
