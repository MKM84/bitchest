<template>
  <div class="row col-12 m-0">
    <Nav-mobile :admin="false" :userInfos="userInfos" />
    <Navigation :admin="false" :userInfos="userInfos" />

    <section class="col ctn-content">
      <Spinner :loading="loading" />
      <div :v-if="cryptos">
        <table class="table mt-4 table-dark table-hover" v-if="loading == false">
          <thead class="thead">
            <tr>
              <th scope="col">Nom</th>
              <th scope="col">Cours actuel (€)</th>
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
                <p class="mb-0">{{ crypto.current_value }}</p>
              </td>
              <td class="align-middle">
                <router-link :to="'/client/crypto-graph/' + crypto.id">
                  <button
                    class="btn btn-primary color-success"
                    title="Consulter l'évolution"
                  >
                    <i class="fas fa-chart-line"></i>
                  </button>
                </router-link>
              </td>
              <td class="align-middle">
                <router-link :to="'/client/buy-crypto/' + crypto.id">
                  <button class="btn btn-primary text-info" title="Acheter">
                    <i class="fas fa-shopping-basket"></i>
                  </button>
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import Spinner from "../../components/Spinner.vue";
import NavMobile from "../../components/NavMobile.vue";
export default {
  name: "UserAllCryptos",
  components: {
    Navigation,
    Spinner,
    NavMobile,
  },
  props: {
    cryptos: { type: Array },
    userInfos: { type: Object },
    loading: { type: Boolean },
  },
};
</script>
<style></style>
