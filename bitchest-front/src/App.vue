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
          console.error(error);
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

:root {
    --bs-primary-rgb: #375675 !important;
}
.btn-primary {
    background-color: #212529 !important;
    border-color: #212529 !important;
}
.bg-primary {
     background-color: #375675 !important;
     color: #375675 !important;
}
.btn-secondary {
    background-color: #00fe17 !important;
    border-color: #00fe17 !important;
}
.btn-secondary:hover {
    background-color: #02b911 !important;
        border-color: #02b911 !important;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
background-color: #2c3034 !important;
}
body {
  position: relative;
  background-color: #2c3034 !important;
}
html {
  background-color: #2c3034 !important;

}
.thead {
  position: sticky;
  top: 0;
  background-color: #ffffff;
}

.ctn-content {
  background-color: #212529;
  border-radius: 30px;
  margin: 20px 10px 23px 0px !important;

}
.btn-space {
    margin-right: 10px;
}
.color-success {
    color: #00fe17 !important;
}
.fixed-alerte {
    position: fixed !important;
    bottom: 10px;
    right: 0px;
}
table img {
    background-color: #fff;
    border-radius: 50%;
    width: 40px;
    padding: 6px;
}

</style>
