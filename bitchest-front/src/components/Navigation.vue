<template>
  <aside class="col-2 bg-info text-center">
      <div class="col-12 text-center mt-4 d-flex justify-content-center align-items-end">
        <img src="../../public/img/bitchest_logo.png" alt="" width="150" />
      </div>
      <div v-if="admin" class="col mt-5">
        <router-link to="/admin/user-list">
          <a
            class="d-block p-2 m-3 fs-6 rounded border border-dark btn btn-outline-dark"
            href="#"
            >Utilisateurs</a
          >
        </router-link>
        <router-link to="/admin">
          <a
            class="d-block p-2 m-3 fs-6 rounded border border-dark btn btn-outline-dark"
            href="#"
            >Cryptomonnaies</a
          >
        </router-link>
        <a
          class="d-block p-2 m-3 mt-5 fs-6 rounded border border-dark btn btn-dark"
          href="#"
          @click.prevent="logout"
          >Logout</a
        >
      </div>
            <div v-else class="col mt-5">
        <router-link to="/client/user-list">
          <a
            class="d-block p-2 m-3 fs-6 rounded border border-dark btn btn-outline-dark"
            href="#"
            >Mon portefeuille</a
          >
        </router-link>
        <router-link to="/admin">
          <a
            class="d-block p-2 m-3 fs-6 rounded border border-dark btn btn-outline-dark"
            href="#"
            >Cryptomonnaies</a
          >
        </router-link>
        <a
          class="d-block p-2 m-3 mt-5 fs-6 rounded border border-dark btn btn-dark"
          href="#"
          @click.prevent="logout"
          >Logout</a
        >
      </div>
    </aside>
</template>

<script>
import User from "../services/User";

export default {
    name: 'Navigation',
    props: {
        admin: {type: Boolean}
    },
    methods: {
    logout() {
      User.logout().then(() => {
        localStorage.removeItem("auth");
        localStorage.removeItem("admin");
        this.$router.push({ name: "login" });
      });
    },
    }


}
</script>

<style>
a {
    text-decoration: none !important;
}
</style>
