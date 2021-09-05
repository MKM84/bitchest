<template>
<!-- bootstrap pictos  -->
  <Pictos />
  <router-view @log-in="logIn" :errors="errors" />
</template>

<script>
import Pictos from "./components/Pictos.vue";
import User from "./services/User";

export default {
  name: "App",
  mounted() {},
  components: {
    Pictos,
  },
  data() {
    return {
      errors: {},
    };
  },
  methods: {
    logIn(form) {
      User.login(form)
        .then((r) => {
          if (r.statusText == "OK") {
            //   save user auth in localle storage
            localStorage.setItem("auth", "true");
            if (r.data.status == 0) {
              // if user is admin
              localStorage.setItem("admin", "true");
              this.$router.push({
                name: "AdminAllCryptos",
              });
              this.errors = {};
            } else {
              // if user is client
              localStorage.setItem("admin", "false");
              this.$router.push({
                name: "Client",
              });
              this.errors = {};
            }
            return r.data;
          }
        })
        .catch((error) => {
          console.log(error);
          //   if user email or password are not correct
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
  background-color: #0d6efd !important;
}
.thead {
  position: sticky;
  top: 0;
  background-color: #ffffff;
}
.ctn-content {
  background-color: #ffffff;
  border-radius: 30px;
  margin: 20px 10px 23px 0px !important;
}
</style>
