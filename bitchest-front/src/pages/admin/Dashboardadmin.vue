<template>
  <div class="col-4 mx-auto py-5 mt-5 bg-light p-5 rounded">
   <h1>dashboar admin</h1>
        <a
          class="nav-item nav-link"
          @click.prevent="logout"
          href="#"
          >Logout</a
        >
  </div>
</template>

<script>
import User from "../../services/User";

export default {
  name: "Dashboardadmin",
    methods: {
    logout() {
      User.logout().then(() => {
        localStorage.removeItem("auth");
        localStorage.removeItem("admin");

        this.$router.push({ name: "login" });
      });
    }
  }
}
</script>
