<template>
  <div class="row col-12">
    <Navigation :admin="false"  :userInfos="userInfos" />
    <section class="col ctn-content">

        <Spinner :loading="loading" />
      <div v-if="cryptosToSell && loading == false">
        <div class="text-end col-11 mt-5">
            <button v-if="cryptosToSell" @click="$emit('sell-all-by-crypto', idCrypto)" class="btn btn-secondary text-dark">Tout vendre</button>
        </div>
        <h3 class="text-center mt-0 text-light">
          <div class="ml-3 mb-2">
            <img :src="`/img/${cryptosToSell.logo}`" alt="" width="30" />
          </div>
          <strong>
            Vendre -
            <span v-if="cryptosToSell.name"> {{ cryptosToSell.name[0] }}</span>
          </strong>
        </h3>
        <p class="mb-3 text-center text-light" v-if="cryptosToSell.actualValue">
          Cours actuel : {{ cryptosToSell.actualValue.progress_value }}
        </p>
        <table class="table table-dark table-hover">
          <thead class="thead">
            <tr>
              <th scope="col">Quantité</th>
              <th scope="col">Cours à l'achat</th>
              <th scope="col">Date d'achat</th>
              <th scope="col">Dépenses (€)</th>
              <th scope="col">Gains / Perte (€)</th>
              <th scope="col">Vendre</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="crypto in cryptosToSell.cryptosToSell" :key="crypto.id">
              <td class="align-middle">{{ crypto.quantity }}</td>
              <td class="align-middle">{{ crypto.purchase_price }} </td>
              <td class="align-middle">{{ crypto.purchase_date }}</td>
              <td class="align-middle">{{ crypto.sum_purchase }} </td>
              <td
                :class="`fs-6 pt-3 pb-3 align-middle ${
                  cryptosToSell.actualValue.progress_value * crypto.quantity -
                    crypto.sum_purchase >
                  0
                    ? ' color-success'
                    : 'text-danger'
                }`"
              >
                {{
                  Math.round(
                    cryptosToSell.actualValue.progress_value * crypto.quantity -
                      crypto.sum_purchase
                  )
                }}

              </td>
              <td class="align-middle ">
                <button
                  @click="$emit('sell-cryptos', crypto.id_transaction)"
                  type="button"
                  class="btn btn-primary text-info"><i class="fas fa-money-bill-wave"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import Spinner from '../../components/Spinner.vue'

export default {
  name: "UserSellCrypto",
  components: {
    Navigation,
    Spinner
  },
  props: {
    cryptosToSell: {},
    userInfos: { type: Object },
    loading: { type: Boolean}
  },
  $emits: ["get-cryptos-to-sell", "sell-cryptos", "sell-all-by-crypto"],
  mounted() {
    const crypto_id = this.$route.params.id;
    this.$emit("get-cryptos-to-sell", crypto_id);
  },

  data() {
    return {
      crypto: {},
      idCrypto: this.$route.params.id
    };
  },
  methods: {},
};
</script>
<style></style>
