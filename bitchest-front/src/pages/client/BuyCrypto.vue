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
      <h3 class="text-center mt-5 text-light" v-if="crypto && loading == false">
        <div class="ml-3 mb-2">
          <img :src="`/img/${crypto.logo}`" alt="" width="30" />
        </div>
        Acheter des {{ crypto.name }}
      </h3>

      <p class="mb-3 text-center text-light" v-if="crypto">
        Cours actuel : {{ crypto.current_value }}
      </p>

      <form
        @submit.prevent="activModal('Êtes-vous sûr de vouloir effectuer cet achat ?')"
        class="col-6 offset-3 mt-5 col-sm-6 offset-sm-3 mt-5 col-md-6 offset-md-3 mt-5 mb-5"
      >
        <div class="mb-4 text-center">
          <label for="quantity" class="form-label fs-6 mt-3 text-light">Quantité </label>
          <input
            name="quantity"
            type="text"
            class="form-control"
            id="quantity"
            aria-describedby="quantity"
            v-model="cryptoToBuy.quantity"
            @keyup="calculateTotal"
            autocomplete="off"
          />

          <div
            id="lastnameError"
            class="form-text text-danger text-center"
            v-if="v$.cryptoToBuy.quantity.$error"
          >
            {{ v$.cryptoToBuy.quantity.$errors[0].$message }}
          </div>

          <div class="form-label fs-6 mt-4 text-light text-center">
            <p>Total à payer :</p>
            <p class="color-success">
              <strong>{{ this.total }} €</strong>
            </p>
          </div>
        </div>

        <div class="text-center mt-5">
          <button type="submit" class="btn btn-secondary text-dark mt-2 btn-space">
            Acheter
          </button>
          <router-link to="/client/user-wallet">
            <button type="button" class="btn btn-outline-light mt-2">Annuler</button>
          </router-link>
        </div>
      </form>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import NavMobile from "../../components/NavMobile.vue";
import Modal from "../../components/Modal.vue";
import useVuelidate from "@vuelidate/core";
import { required, minValue, maxValue, numeric, integer } from "@vuelidate/validators";

import Spinner from "../../components/Spinner.vue";

export default {
  name: "BuyCrypto",
  components: {
    Navigation,
    NavMobile,
    Spinner,
    Modal,
  },
  emits: ["buy-new-crypto"],
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  props: {
    userInfos: { type: Object },
    cryptos: { type: Array },
    loading: { type: Boolean },
  },
  data() {
    return {
      total: 0,
      crypto: {},
      cryptoToBuy: {
        cryptocurrency_id: 0,
        quantity: 0,
      },
      showModal: false,
      modalContent: "",
      positivAction: null,
      NegativAction: () => (this.showModal = false),
    };
  },

  mounted() {
    const id_crypto = this.$route.params.id;
    let crypto = this.cryptos.find((c) => c.id == id_crypto);
    this.crypto = crypto;
  },
  beforeUpdate() {
    const id_crypto = this.$route.params.id;
    let crypto = this.cryptos.find((c) => c.id == id_crypto);
    this.crypto = crypto;
  },
  validations() {
    return {
      cryptoToBuy: {
        cryptocurrency_id: { required, integer },
        quantity: {
          required,
          minValue: minValue(1),
          maxValue: maxValue(300),
          numeric,
        },
      },
    };
  },
  methods: {
    onSubmit() {
      this.v$.$validate();
      if (this.v$.$error) {
        return false;
      }
      const id_crypto = this.$route.params.id;
      this.cryptoToBuy.cryptocurrency_id = id_crypto;

      this.$emit("buy-new-crypto", this.cryptoToBuy);

      this.$router.push("/client/user-wallet");
    },
    calculateTotal() {
      const id_crypto = this.$route.params.id;
      let crypto = this.cryptos.find((c) => c.id == id_crypto);
      this.total = this.cryptoToBuy.quantity * crypto.current_value;
    },
    activModal(t) {
      this.v$.$validate();
      if (this.v$.$error) {
        return false;
      }
      this.showModal = true;
      this.modalContent = t;
      this.positivAction = async () => {
        await this.onSubmit();
        return (this.showModal = false);
      };
    },
  },
};
</script>
<style></style>
