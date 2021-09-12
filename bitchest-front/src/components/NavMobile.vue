<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
      <h2 class="text-info mb-0 mx-5"><strong>BitChest</strong></h2>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div v-if="admin" class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link to="/admin/cryptos" class="nav-link text-light fs-9 px-2">
             <i class="fab fa-bitcoin 3x"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/admin/user-list" class="nav-link text-light fs-9 px-2">
              <i class="fas fa-users-cog"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              to="/admin/user-form/0"
              class="nav-link text-light fs-9 px-2"
            >
             <i class="fas fa-plus-circle"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/admin/admin-form" class="nav-link text-light fs-9 px-2">
             <i class="fas fa-user-circle 3x"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <a
              class="nav-link nav-link text-light fs-9 px-2"
              href="#"
              @click.prevent="logout"
            >
             <i class="fas fa-power-off"></i> </a
            >
          </li>
        </ul>

      </div>

      <div v-else class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link to="/client/cryptos" class="nav-link text-light fs-9 px-2">
              <i class="fab fa-bitcoin 3x"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/client/user-wallet" class="nav-link text-light fs-9 px-2">
              <i class="fas fa-wallet 3x"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              to="/client/purchase-history"
              class="nav-link text-light fs-9 px-2"
            >
              <i class="fas fa-history 3x"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/client/user-form" class="nav-link text-light fs-9 px-2">
             <i class="fas fa-user-circle 3x"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <a
              class="nav-link nav-link text-light fs-9 px-2"
              href="#"
              @click.prevent="logout"
            >
               <i class="fas fa-power-off"></i></a
            >
          </li>
        </ul>
        <div  class="d-flex">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li
              v-if="userInfos.user_solde"
              :class="`nav-item ${
                userInfos.user_solde > 0 ? 'color-success' : 'text-danger'
              }`"
            >
              Solde : {{ userInfos.user_solde }} €
            </li>

                        <li
              v-if="userInfos.user_money"
              :class="`nav-item ${
                userInfos.user_money > 0 ? 'color-success' : 'text-danger'
              }`"
            >
              Bank : {{ userInfos.user_money }} €
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import User from "../services/User";

export default {
  name: "NavMobile",
  props: {
    admin: { type: Boolean },
    userInfos: { type: Object },
    adminInfos: { type: Object },
  },
  methods: {
    logout() {
      User.logout().then(() => {
        localStorage.removeItem("auth");
        localStorage.removeItem("admin");
        this.$router.push({ name: "login" });
      });
    },
  },
};
</script>

<style></style>
