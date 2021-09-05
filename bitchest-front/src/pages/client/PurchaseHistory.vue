<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col ctn-content">
      <h3 class="text-center mt-5 mb-5 text-dark">
        <strong>Historique de mes achats</strong>
      </h3>
      <table class="table" v-if="userHistory">
        <thead class="thead">
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Quantité</th>
            <th scope="col">Date d'achat</th>
            <th scope="col">Cours à l'achat</th>
            <th scope="col">Dépenses</th>
            <th scope="col">État</th>
            <th scope="col">Date de vente</th>
            <th scope="col">Cours à la vente</th>
            <th scope="col">Gains / Pertes</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="transaction in userHistory" :key="transaction.id">
            <td class="fs-6 pt-3 pb-3 align-middle">
              <img :src="`/img/${transaction.logo}`" alt="" width="30" />
              {{ transaction.name_crypto }}
            </td>

            <td class="fs-6 pt-3 pb-3 align-middle">{{ transaction.quantity }}</td>
            <td class="fs-6 pt-3 pb-3 align-middle">{{ transaction.purchase_date }}</td>
            <td class="fs-6 pt-3 pb-3 align-middle">{{ transaction.purchase_price }} €</td>
            <td class="fs-6 pt-3 pb-3 align-middle">{{ transaction.sum_purchase }} €</td>
            <td class="align-middle">
              <span
                :class="`badge ${
                  transaction.state === 0
                    ? 'bg-warning text-dark'
                    : 'bg-success text-light'
                }`"
              >
                {{ transaction.state === 0 ? "Non-vendu" : "Vendu" }}</span
              >
            </td>
            <td class="fs-6 pt-3 pb-3 align-middle">
              {{ transaction.selling_date ?? "- " }}
            </td>
            <td class="fs-6 pt-3 pb-3 align-middle">
              {{ transaction.selling_price  ?? "- " }} €
            </td>
            <td
              :class="`fs-6 pt-3 pb-3 align-middle ${
               transaction.balance > 1 ? ' text-success' : 'text-danger'
              }`"
            >
              {{ transaction.balance  ?? "-" }} €
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
  name: "PurchaseHistory",
  components: {
    Navigation,
  },
  props: {
    userSolde: { type: Number },
    userHistory: { type: Array },
  },

  mounted() {},
  data() {
    return {};
  },
  methods: {},
};
</script>
<style>

</style>
