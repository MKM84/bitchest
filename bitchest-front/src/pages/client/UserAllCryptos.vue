<template>
  <div class="row col-12">

    <Navigation :admin="admin"/>

    <section class="col">
      <h4 class="text-left mt-5 mb-3">Liste des cryptomonnaies</h4>
      <table class="table table-borderless table-hover">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Cours actuel</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="crypto in cryptos" :key="crypto.id">
            <td class="fs-5">
              <img :src="`img/${crypto.logo}`" alt="" width="25" /> {{ crypto.name }}
            </td>
            <td class="fs-5">{{ crypto.current_value }} €</td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
import User from "../../services/User";
import Navigation from "../../components/Navigation.vue"
export default {
  name: "AdminAllCryptos",
  components: {
      Navigation
      },
  mounted() {
    this.getAllUserCurrencies();
  },
  data() {
    return {
        cryptos: {},
        admin: false
        };
  },
  methods: {

    getAllUserCurrencies() {
      User.getAllUserCurrencies().then((r) => {
        this.cryptos = r.data.currencies;
        console.log(this.cryptos);
      });
    },
  },
};
</script>
<style>

</style>
