<template>
  <Pictos />
  <router-view @get-all-users="getAllUsers" :userList="userList" :admin="admin" />
</template>

<script>
import Pictos from "./components/Pictos.vue";
import User from "./services/User";

export default {
  name: "App",
  mounted() {
    this.isAdmin();
  },
  props: {},
  components: {
    Pictos,
  },
  data() {
    return {
      userList: {},
      admin: "",
    };
  },
  methods: {
    isAdmin() {
      let userIsAdmin = localStorage.getItem("admin");
      if (userIsAdmin) {
        this.admin = true;
        this.getAllUsers();
      }
    },
    getAllUsers() {
      User.getAllUsers().then((r) => {
        this.userList = r.data.userList;
        console.log(this.userList);
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
