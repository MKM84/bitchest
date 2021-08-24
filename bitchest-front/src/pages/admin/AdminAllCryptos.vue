<template>
  <div class="row col-12">
    <aside class="col-2 bg-light">
      <div class="col-12 text-center mt-4 d-flex justify-content-center align-items-end">
        <img src="../../assets/img/bitchest_logo.png" alt="" width="200" />
      </div>
      <div class="col-12 mt-5">
        <a
          class="text-center d-block p-2 m-3 nav-link fs-6 text-dark rounded border border-dark aside-link"
          href="#"
          >Utilisateurs</a
        >
        <a
          class="text-center d-block p-2 m-3 nav-link fs-6 text-dark rounded border border-dark aside-link"
          href="#"
          >Cryptomonnaies</a
        >
        <a
          class="text-center d-block p-2 m-3 nav-link fs-6 text-light bg-dark rounded border border-dark aside-link"
          href="#"
          @click.prevent="logout"
          >Logout</a
        >
      </div>
    </aside>
    <section class="col-10">
      <h4 class="text-left mt-5 mb-3">Liste des cryptomonnaies</h4>
      <table class="table">
        <thead>
          <tr class="">
            <th scope="col">Nom</th>
            <th scope="col">Cours actuel</th>
          </tr>
        </thead>
        <tbody >
          <tr v-for="crypto in cryptos" :key="crypto.id">
            <td>

                <img :src="`../../assets/img/${crypto.logo}`" alt="" width="25" /> {{crypto.name}}</td>
             <td>
                {{crypto.current_value}} €
            </td>
          </tr>

        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
import User from "../../services/User";

export default {
  name: "AdminAllCryptos",
  mounted() {
    this.getCurrencies();
  },
  data() {
    return { cryptos: {} };
  },
  methods: {
    logout() {
      User.logout().then(() => {
        localStorage.removeItem("auth");
        localStorage.removeItem("admin");

        this.$router.push({ name: "login" });
      });
    },
    getCurrencies() {
      User.getAllCurrencies().then((r) => {
        this.cryptos = r.data.currencies;
        console.log(this.cryptos);

      });
    },

  },
};
</script>
<style>
body {
  position: relative;
}
aside {
  position: sticky;
  top: 0;
  width: 100%;
  height: 100vh;
}
</style>
