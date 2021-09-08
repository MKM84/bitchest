<template>
  <aside class="col-2 px-0">
    <div class="col-12 text-center mt-4 d-flex justify-content-center align-items-end">
      <img src="../../public/img/bitchest_logo.png" alt="" width="180" />
    </div>
    <!-- admin  -->
    <div v-if="admin" class=" mt-5">
              <router-link to="/admin/cryptos" class="nav-link text-light fs-6 px-4">
        <i class="fab fa-bitcoin 3x"></i> Cryptomonnaies
      </router-link>
      <router-link to="/admin/user-list" class="nav-link text-light fs-6 px-4">
        <i class="fas fa-users-cog"></i> Utilisateurs
      </router-link>

      <router-link to="/admin/user-form/0" class="nav-link text-light fs-6 px-4">
        <i class="fas fa-plus-circle"></i> Ajouter un utilisateur
      </router-link>

      <a class="nav-link nav-link text-light fs-6 px-4  pt-4" href="#" @click.prevent="logout"
        ><i class="fas fa-power-off"></i> Logout</a
      >
    </div>

    <!-- client  -->
    <div v-else class="mt-5">
      <router-link to="/client/cryptos" class="nav-link text-light fs-6 px-4">
        <i class="fab fa-bitcoin 3x"></i> Cryptomonnaies
      </router-link>
      <router-link to="/client/user-wallet" class="nav-link text-light fs-6 px-4">
        <i class="fas fa-wallet 3x"></i> Portefeuille
      </router-link>

      <router-link to="/client/purchase-history" class="nav-link text-light fs-6 px-4">
        <i class="fas fa-history 3x"></i> Historique
      </router-link>

      <router-link to="/client/user-form" class="nav-link nav-link text-light fs-6 px-4">
        <i class="fas fa-user-circle 3x"></i> Mon compte
      </router-link>
                    <a class="nav-link nav-link text-light fs-6 px-4  pt-4" href="#" @click.prevent="logout"
        ><i class="fas fa-power-off"></i> Me déconnecter</a
      >


          <div  class="mt-5 px-4 ">
              <h5 v-if="userInfos.firstname" class="text-light">Bonjour {{ userInfos.firstname }},</h5>
            <p v-if="userInfos.user_solde" class="mb-1 text-light">Votre solde est de :</p>
            <p v-if="userInfos.user_solde" :class="`mb-0 ${userInfos.user_solde > 0 ? 'color-success' : 'text-danger'}`">
              <strong>{{ userInfos.user_solde }} €</strong>
            </p>
          </div>


    </div>
  </aside>
</template>

<script>
import User from "../services/User";

export default {
  name: "Navigation",
  props: {
    admin: { type: Boolean },
    userInfos: { type: Object}
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

<style>
a {
  text-decoration: none !important;
}

aside {
  position: sticky;
  top: 0;
  height: 100vh;
  /* min-width: 250px; */
  background-color: #2c3034 !important;
}
.router-link-active {
  font-weight: 700;
  background-color: #212529;
  color: #00fe17 !important;
  /* border-radius: 0px 50px 50px 0px; */
}
</style>
