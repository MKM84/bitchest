<template>
<div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col">
      <h3 class="text-left mt-5 mb-3 text-info">Mon portefeuille</h3>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Cryptomonnaies</th>
            <th scope="col">Cours actuel</th>
            <th scope="col">Quantité </th>
            <th scope="col">Dépeses</th>
            <th scope="col">Historique</th>
            <th scope="col">Vendre</th>

          </tr>
        </thead>
        <tbody>
          <tr >
            <td class="fs-6 pt-3 pb-3">
              Crypto
            </td>
            <td class="fs-6 pt-3 pb-3">10000€</td>
            <td class="fs-6 pt-3 pb-3">5</td>
            <td class="fs-6 pt-3 pb-3">220000€</td>

            <td class="fs-6 pt-3 pb-3">
              <router-link :to="'/client/purchase-history/:id'">
                <button type="button" class="btn btn-info">
                 <i class="fas fa-history"></i>
                </button>
              </router-link>
            </td>
            <td class="fs-6 pt-3 pb-3">
              <router-link :to="'/client/user-sell-crypto/:id'">
                <button type="button" class="btn btn-light">
                 <i class="fas fa-euro-sign"></i>
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
  name: "UserWallet",
  components: {
    Navigation,
  },
  props: {
    wallet: { type: Array },
      userSolde: { type: Number },
  },
  mounted() {

  },
  data() {
    return {

    };
  },
  methods: {

  },
};
</script>
<style></style>
