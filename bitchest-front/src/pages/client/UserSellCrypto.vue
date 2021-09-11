<template>
  <div class="row col-12 m-0">
    <Nav-mobile :admin="false" :userInfos="userInfos" />
    <Navigation :admin="false" :userInfos="userInfos" />
    <Modal
      v-if="showModal"
      :showModal="activModal"
      :modalContent="modalContent"
      :positivAction="positivAction"
      :NegativAction="NegativAction"
    />
    <section class="col ctn-content">
      <Spinner :loading="loading" />
      <div v-if="cryptosToSell && loading == false">
        <div class="text-end col-11 mt-5">
          <button
            v-if="cryptosToSell"
            @click="
              activModal2(`Êtes-vous sûr de vouloir effectuer cette vente ?`, idCrypto)
            "
            class="btn btn-secondary text-dark"
          >
            Tout vendre
          </button>
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
              <td class="align-middle">{{ crypto.purchase_price }}</td>
              <td class="align-middle">{{ crypto.purchase_date }}</td>
              <td class="align-middle">{{ crypto.sum_purchase }}</td>
              <td
                :class="`fs-6 pt-3 pb-3 align-middle ${
                  cryptosToSell.actualValue.progress_value * crypto.quantity -
                    crypto.sum_purchase >
                  0
                    ? ' color-green'
                    : 'color-red'
                }`"
              >
                {{
                  Math.round(
                    cryptosToSell.actualValue.progress_value * crypto.quantity -
                      crypto.sum_purchase
                  )
                }}
              </td>
              <td class="align-middle">
                <button
                  @click="
                    activModal(
                      `Êtes-vous sûr de vouloir effectuer cette vente ?`,
                      crypto.id_transaction
                    )
                  "
                  type="button"
                  class="btn btn-primary text-info"
                >
                  <i class="fas fa-money-bill-wave"></i>
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
import NavMobile from "../../components/NavMobile.vue";
import Spinner from "../../components/Spinner.vue";
import Modal from "../../components/Modal.vue";
export default {
  name: "UserSellCrypto",
  components: {
    Navigation,
    NavMobile,
    Spinner,
    Modal,
  },
  props: {
    cryptosToSell: {},
    userInfos: { type: Object },
    loading: { type: Boolean },
  },
  $emits: ["get-cryptos-to-sell", "sell-cryptos", "sell-all-by-crypto"],
  mounted() {
    const crypto_id = this.$route.params.id;
    this.$emit("get-cryptos-to-sell", crypto_id);
  },

  data() {
    return {
      crypto: {},
      idCrypto: this.$route.params.id,
      showModal: false,
      modalContent: "",
      positivAction: null,
      NegativAction: () => (this.showModal = false),
    };
  },
  methods: {
    activModal(t, crypto_id) {
      this.showModal = true;
      this.modalContent = t;
      this.positivAction = async () => {
        await this.$emit("sell-cryptos", crypto_id);
        return (this.showModal = false);
      };
    },
    activModal2(t, crypto_id) {
      this.showModal = true;
      this.modalContent = t;
      this.positivAction = async () => {
        await this.$emit("sell-all-by-crypto", crypto_id);
        return (this.showModal = false);
      };
    },
  },
};
</script>
<style></style>
