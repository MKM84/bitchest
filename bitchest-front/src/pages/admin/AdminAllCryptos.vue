<template>
  <div class="row col-12">
    <Navigation :admin="true" />

    <section class="col ctn-content">
      <h3 class="text-center mt-5 mb-5 text-dark"><strong>Les cryptomonnaies</strong></h3>
      <table class="table" :v-if="cryptos">
        <thead>
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
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
export default {
  name: "AdminAllCryptos",
  components: {
    Navigation,
  },
  props: {
    cryptos: { type: Array},
  },

};
</script>
<style></style>
