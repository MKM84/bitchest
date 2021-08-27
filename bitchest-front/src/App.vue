<template>
  <Pictos />
  <router-view
    @get-all-users="getAllUsers"
    :userList="userList"
    @get-all-admincryptos="getAllAdminCryptos"
    :cryptos="cryptos"
    @login="login"
  />
</template>

<script>
import Pictos from "./components/Pictos.vue";
import User from "./services/User";

export default {
  name: "App",
  mounted() {
    this.getAllUsers();
    this.getAllAdminCryptos();
  },
  components: {
    Pictos,
  },
  data() {
    return {
      userList: [],
      cryptos: [],
    };
  },
  methods: {
    login(form) {
      User.login(form)
        .then((r) => {
          if (r.statusText == "OK") {
            console.log(r);
            localStorage.setItem("auth", "true");
            if (r.data.status == 0) {
              localStorage.setItem("admin", "true");
              this.getAllUsers();
              this.getAllAdminCryptos();
              this.$router.push({
                name: "AdminAllCryptos",
              });
            } else {
              localStorage.setItem("admin", "false");
              this.$router.push({
                name: "UserAllCryptos",
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
    getAllUsers() {
      if (localStorage.getItem("admin") != null) {
        if (localStorage.getItem("admin") == "true") {
          User.getAllUsers().then((r) => {
            this.userList = r.data.userList;
          });
        } else return;
      }
    },
    getAllAdminCryptos() {
      if (localStorage.getItem("admin") != null) {
        if (localStorage.getItem("admin") == "true") {
          User.getAllAdminCryptos().then((r) => {
            this.cryptos = r.data.currencies;
          });
        }
      } else return;
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
