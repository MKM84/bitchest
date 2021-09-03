<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col" v-if="cryptosToSell">
      <h3 class="text-left mt-5 mb-3 text-info">
        <img :src="`/img/${cryptosToSell.logo}`" alt="" width="30" />
         <span  v-if="cryptosToSell.name"> {{ cryptosToSell.name[0]}}</span>
à Vendre
      </h3>
      <p v-if="cryptosToSell.actualValue">Cours actuel : {{cryptosToSell.actualValue.progress_value}}</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Quantité</th>
            <th scope="col">Cours à l'achat</th>
            <th scope="col">Date d'achat</th>
            <th scope="col">Dépenses</th>
            <th scope="col">Gains / Perte</th>
            <th scope="col">Vendre</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="crypto in cryptosToSell.cryptosToSell" :key="crypto.id">
            <td class="fs-6 pt-3 pb-3">{{ crypto.quantity }}</td>
            <td class="fs-6 pt-3 pb-3">{{ crypto.purchase_price }}</td>
            <td class="fs-6 pt-3 pb-3">{{ crypto.purchase_date }}</td>
            <td class="fs-6 pt-3 pb-3">{{ crypto.sum_purchase }}</td>

            <td class="fs-6 pt-3 pb-3"> {{Math.round(cryptosToSell.actualValue.progress_value * crypto.quantity - crypto.sum_purchase)}}</td>
            <td class="fs-6 pt-3 pb-3">
              <button @click="$emit('sell-cryptos', crypto.id_transaction)" type="button" class="btn btn-info">
                <i class="fas fa-euro-sign"></i>
              </button>
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
  name: "UserSellCrypto",
  components: {
    Navigation,
  },
  props: {
    cryptosToSell: { },
    userSolde: { type: Number },
  },
  $emits: ["get-cryptos-to-sell", 'sell-cryptos'],
  mounted() {
    const crypto_id = this.$route.params.id;
    this.$emit("get-cryptos-to-sell", crypto_id);

  },
//   beforeUpdate() {
//     const crypto_id = this.$route.params.id;
//     this.$emit("get-cryptos-to-sell", crypto_id);

//   },
  data() {
    return {
      crypto: {},
    };
  },
  methods: {

  },
};
</script>
<style></style>
