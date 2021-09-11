<template>
  <div class="row col-12 m-0">
    <Nav-mobile :admin="true" :adminInfos="adminInfos"/>
    <Navigation :admin="true" :adminInfos="adminInfos" />
    <section class="col ctn-content">
      <Spinner :loading="loading" />
      <div :v-if="cryptos">
        <table class="table mt-4 table-dark table-hover" :v-if="loading == false">
          <thead class="thead">
            <tr>
              <th scope="col">Nom</th>
              <th scope="col">Cours actuel</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="crypto in cryptos" :key="crypto.id">
              <td class="fs-6 pt-3 pb-3 align-middle">
                <img :src="`/img/${crypto.logo}`" alt="" width="30" /> {{ crypto.name }}
              </td>
              <td class="fs-6 pt-3 pb-3 align-middle">{{ crypto.current_value }} €</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import NavMobile from "../../components/NavMobile.vue"
import Spinner from "../../components/Spinner.vue";

export default {
  name: "AdminAllCryptos",
  components: {
    Navigation,
    NavMobile,
    Spinner,
  },
  props: {
    cryptos: { type: Array },
    loading: { type: Boolean },
    adminInfos: {
      type: Object,
    },
  },
};
</script>
<style></style>
