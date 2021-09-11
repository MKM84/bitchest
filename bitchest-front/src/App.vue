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
@import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,300;1,500;1,700&display=swap");

body {
  position: relative;
  background-color: #2c3034 !important;
}
html {
  background-color: #2c3034 !important;
}
#app {
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  background-color: #2c3034 !important;
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
  background-color: #0dcaf0 !important;
  border-color: #0dcaf0 !important;
}
.btn-secondary:hover {
  background-color: #09a6c5 !important;
  border-color: #09a6c5 !important;
}
.thead {
  position: sticky;
  top: 0;
}

.ctn-content {
  background-color: #212529;
  border-radius: 30px;
}
.btn-space {
  margin-right: 10px;
}
.color-success {
  color: #0dcaf0 !important;
}
.color-green {
  color: #46ea9b !important;
}
.color-red {
  color: #f82c55 !important;
}
.fixed-alerte {
  position: fixed !important;
  bottom: 10px;
  right: 0px;
}
img {
  background-color: #fff;
  border-radius: 50%;
  width: 48px;
  padding: 6px;
  margin-right: 6px;
  border: 3px solid #0dcaf0;
}
a {
  text-decoration: none !important;
}

aside {
  position: sticky;
  top: 0;
  height: 100vh;
  background-color: #2c3034 !important;
}
.router-link-active {
  font-weight: 700;
  background-color: #212529;
}

@media (min-width: 300px) and (max-width: 1100px) {
  aside {
    display: none;
  }
  nav {
    display: initial;
  }
  .ctn-content {
    margin: 20px 10px 23px 10px !important;
  }
  .router-link-active {
    background-color: transparent;
  }
}

@media (min-width: 1099px) {
  aside {
    display: block;
  }
  nav {
    display: none !important;
  }
  .ctn-content {
    margin: 20px 10px 23px 0px !important;
  }
}
</style>
