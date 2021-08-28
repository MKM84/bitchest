<template>
  <Pictos />
  <router-view

    @log-in="logIn"

  />
</template>

<script>
import Pictos from "./components/Pictos.vue";
import User from "./services/User";

export default {
  name: "App",
  mounted() {

  },
  components: {
    Pictos,
  },
  data() {
    return {

    };
  },
  methods: {
    logIn(form) {
      User.login(form)
        .then((r) => {
          if (r.statusText == "OK") {
            console.log(r);
            localStorage.setItem("auth", "true");
            if (r.data.status == 0) {
              localStorage.setItem("admin", "true");

              this.$router.push({
                name: "AdminAllCryptos",
              });
            } else {
              localStorage.setItem("admin", "false");
              this.$router.push({
                name: "Client",
              });
            }
            return r.data;
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          }
        });
    },

  },
};
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
