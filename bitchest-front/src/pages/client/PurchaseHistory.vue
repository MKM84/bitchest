<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col">
      <h3 class="text-left mt-5 mb-3 text-info">Historique de mes achats (Bitcoin)</h3>
      <p>Cours actuel : 55555 €</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">État</th>
            <th scope="col">Quantité</th>
            <th scope="col">Date d'achat</th>
            <th scope="col">Cours à l'achat</th>
            <th scope="col">Date de vente</th>
            <th scope="col">Cours à la vente</th>
            <th scope="col">Gains / Pertes</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="fs-6 pt-3 pb-3">test</td>
            <td class="fs-6 pt-3 pb-3">test</td>
            <td class="fs-6 pt-3 pb-3">test</td>
            <td class="fs-6 pt-3 pb-3">test</td>
            <td class="fs-6 pt-3 pb-3">test</td>
            <td class="fs-6 pt-3 pb-3">test</td>
            <td class="fs-6 pt-3 pb-3">test</td>
            <td class="fs-6 pt-3 pb-3">test</td>

          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
export default {
  name: "PurchaseHistory",
  components: {
    Navigation,
  },
  props: {
    userTransactions: { type: Array },
    userSolde: { type: Number },

  },
  mounted() {},
  data() {
    return {};
  },
  methods: {},
};
</script>
<style></style>
