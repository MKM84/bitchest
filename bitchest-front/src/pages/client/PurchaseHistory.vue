<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col">
      <h3 class="text-left mt-5 mb-3 text-info">Historique de mes achats</h3>
      <table class="table" v-if="userHistory">
        <thead>
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
            <td class="fs-6 pt-3 pb-3">
              <img :src="`/img/${transaction.logo}`" alt="" width="30" />
              {{ transaction.name_crypto }}
            </td>


            <td class="fs-6 pt-3 pb-3">{{ transaction.quantity }}</td>
            <td class="fs-6 pt-3 pb-3">{{ transaction.purchase_date }}</td>
            <td class="fs-6 pt-3 pb-3">{{ transaction.purchase_price }}</td>
            <td class="fs-6 pt-3 pb-3">{{ transaction.sum_purchase }}</td>
                                    <td

            ><span          :class="`badge ${
                transaction.state === 0 ? 'bg-info text-dark' : 'bg-danger text-light'
              }`">
              {{ transaction.state === 0 ? "Non-vendu" : "Vendu" }}</span>
            </td>
            <td class="fs-6 pt-3 pb-3">{{ transaction.selling_date }}</td>
            <td class="fs-6 pt-3 pb-3">{{ transaction.selling_price }}</td>
            <td class="fs-6 pt-3 pb-3">{{ transaction.balance }}</td>

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
    userHistory : { type: Array}
  },

  mounted() {

  },
  data() {
    return {
    };
  },
  methods: {},
};
</script>
<style></style>
