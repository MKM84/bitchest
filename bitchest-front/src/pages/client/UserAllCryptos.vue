<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col">
      <h3 class="text-left mt-5 mb-3 text-info">Les cryptomonnaies</h3>
      <table class="table" :v-if="cryptos">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Cours actuel</th>
            <th scope="col">Nom</th>
            <th scope="col">Cours actuel</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="crypto in cryptos" :key="crypto.id">
            <td class="fs-6 pt-3 pb-3">
              <img :src="`/img/${crypto.logo}`" alt="" width="30" /> {{ crypto.name }}
            </td>
            <td class="fs-6 pt-3 pb-3">{{ crypto.current_value }} €</td>
            <td class="fs-6 pt-3 pb-3">
        <router-link :to="'/client/crypto-graph/'+ crypto.id">
              <button type="button" class="btn btn-info">
                Évolution
              </button>
      </router-link>
            </td>
                        <td class="fs-6 pt-3 pb-3">
        <router-link :to="'/client/purchase-form/'+ crypto.id">
              <button type="button" class="btn btn-dark">
                Acheter
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
  mounted() {
    console.log("test");
  },
  data() {
    return {};
  },
  methods: {},
};
</script>
<style></style>
