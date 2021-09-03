<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col">
      <h3 class="text-left mt-5 mb-3 text-info">Mon portefeuille</h3>

      <table class="table" v-if="wallet">
        <thead>
          <tr>
            <th scope="col">Cryptomonnaies</th>
            <th scope="col">Quantité</th>
            <th scope="col">Dépeses</th>
            <th scope="col">Cours actuel</th>
            <th scope="col">Vendre</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="wall in wallet" :key="wall.id">
            <td class="fs-6 pt-3 pb-3">
              <img :src="`/img/${wall.logo_crypto}`" alt="" width="30" />
              {{ wall.name_crypto }}
            </td>
            <td class="fs-6 pt-3 pb-3">{{ wall.quantity_sum }}</td>
            <td class="fs-6 pt-3 pb-3">{{ wall.prices_sum }} €</td>
            <td class="fs-6 pt-3 pb-3">{{ wall.current_value }} €</td>

            <td class="fs-6 pt-3 pb-3">
              <router-link :to="'/client/user-sell-crypto/' + wall.id_crypto">
                <button type="button" class="btn btn-light">
                  <i class="fas fa-euro-sign"></i>
                </button>
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    <Alerte v-if="showAlerte" :showAlerte="showAlerte" :alerteContent="alerteContent"/>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import Alerte from "../../components/Alerte.vue";

export default {
  name: "UserWallet",
  components: {
    Navigation,
    Alerte,
  },
  props: {
    wallet: { type: Array },
    userSolde: { type: Number },
    showAlerte: {type: Boolean},
    alerteContent: {type: String}

  },
  mounted() {
    // this.$emit('get-user-wallet');
  },
  data() {
    return {};
  },
  methods: {},
};
</script>
<style></style>
