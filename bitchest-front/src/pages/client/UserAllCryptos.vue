<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col ctn-content">
      <h3 class="text-center mt-5 mb-5 text-dark">
        <strong>Toutes les cryptomonnaies</strong>
      </h3>
      <table class="table" :v-if="cryptos">
        <thead class="thead">
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Cours actuel</th>
            <th scope="col">Évolution</th>
            <th scope="col">Acheter</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="crypto in cryptos" :key="crypto.id">
            <td class="align-middle p-3">
              <p class="mb-0">
                <img :src="`/img/${crypto.logo}`" alt="" width="30" /> {{ crypto.name }}
              </p>
            </td>
            <td class="align-middle">
              <p class="mb-0">{{ crypto.current_value }} €</p>
            </td>
            <td class="align-middle">
              <router-link :to="'/client/crypto-graph/' + crypto.id">
                <button class="btn btn-primary"><i class="fas fa-chart-line"></i></button>
              </router-link>
            </td>
            <td class="align-middle">
              <router-link :to="'/client/buy-crypto/' + crypto.id">
                <button class="btn btn-primary">
                  <i class="fas fa-shopping-basket"></i>
                </button>
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
export default {
  name: "UserAllCryptos",
  components: {
    Navigation,
  },
  props: {
    cryptos: { type: Array },
    userSolde: { type: Number },
  },
  mounted() {},
  data() {
    return {};
  },
  methods: {},
};
</script>
<style>
.ctn-content {
  background-color: #ffffff;
  border-radius: 30px;
  margin: 20px 10px 23px 0px !important;
}
</style>
