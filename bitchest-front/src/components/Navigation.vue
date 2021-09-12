<template>
  <aside class="col-2 px-0">
    <div class="text-start mt-5 px-4">
      <router-link to="/" class="nav-link text-light fs-6 px-4">
        <h2 class="text-info"><strong>BitChest</strong></h2>
      </router-link>
    </div>
    <!-- admin  -->
    <div v-if="admin" class="mt-5">
      <router-link to="/admin/cryptos" class="nav-link text-light fs-6 px-4">
        <i class="fab fa-bitcoin 3x"></i> Cryptomonnaies
      </router-link>
      <router-link to="/admin/user-list" class="nav-link text-light fs-6 px-4">
        <i class="fas fa-users-cog"></i> Utilisateurs
      </router-link>

      <router-link to="/admin/user-form/0" class="nav-link text-light fs-6 px-4">
        <i class="fas fa-plus-circle"></i> Ajouter un utilisateur
      </router-link>

      <router-link to="/admin/admin-form" class="nav-link text-light fs-6 px-4">
        <i class="fas fa-user-circle 3x"></i> Mon compte
      </router-link>
      <div class="mt-5 px-4 mb-5">
        <h5 v-if="adminInfos" class="text-light">Bonjour {{ adminInfos.firstname }} !</h5>
      </div>
      <a
        class="nav-link nav-link text-info fs-6 px-4 pt-4"
        href="#"
        @click.prevent="logout"
        ><i class="fas fa-power-off"></i> Me déconnecter</a
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

      <div class="mt-5 px-4 mb-5">
        <h5 v-if="userInfos.firstname" class="text-light">
          Bonjour {{ userInfos.firstname }},
        </h5>
        <p v-if="userInfos.user_solde" class="mb-1 text-light">
          La valeur de vos cryptomonnaies :
        </p>
        <p
          v-if="userInfos.user_solde"
          :class="`mb-0 ${userInfos.user_solde > 0 ? 'color-green' : 'text-danger'}`"
        >
          <strong>{{ userInfos.user_solde }} €</strong>
        </p>

        <p v-if="userInfos.user_money" class="mb-1 mt-3 text-light">Votre solde bancaire :</p>
        <p
          v-if="userInfos.user_money"
          :class="`mb-0 ${userInfos.user_money > 0 ? 'color-green' : 'text-danger'}`"
        >
          <strong>{{ userInfos.user_money }} €</strong>
        </p>
      </div>

      <a
        class="nav-link nav-link text-info fs-6 px-4 pt-4"
        href="#"
        @click.prevent="logout"
        ><i class="fas fa-power-off"></i> Me déconnecter</a
      >
    </div>
  </aside>
</template>

<script>
import User from "../services/User";

export default {
  name: "Navigation",
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
