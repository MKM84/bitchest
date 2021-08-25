<template>
  <div class="row col-12">

    <Navigation :admin="admin" />

    <section class="col cryptos">
      <h3 class="text-left mt-5 mb-3 text-info">Les cryptomonnaies</h3>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Cours actuel</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="crypto in cryptos" :key="crypto.id">
            <td class="fs-6 pt-3 pb-3">
              <img :src="`img/${crypto.logo}`" alt="" width="30" /> {{ crypto.name }}
            </td>
            <td class="fs-6 pt-3 pb-3">{{ crypto.current_value }} €</td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
import User from "../../services/User";
import Navigation from "../../components/Navigation.vue";
export default {
  name: "AdminAllCryptos",
  components: {
    Navigation,
  },
  mounted() {
    this.getAllAdminCurrencies();
  },
  data() {
    return {
      cryptos: {},
      admin: true,
    };
  },
  methods: {
    getAllAdminCurrencies() {
      User.getAllAdminCurrencies().then((r) => {
        this.cryptos = r.data.currencies;
        console.log(this.cryptos);
      });
    },
  },
};
</script>
<style>


</style>
