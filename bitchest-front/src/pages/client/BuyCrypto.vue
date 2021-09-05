<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col ctn-content">
      <h3 class="text-center mt-5 text-dark" v-if="crypto">
        <div class="ml-3 mb-2">
          <img :src="`/img/${crypto.logo}`" alt="" width="30" />
        </div>
        Acheter des {{ crypto.name }}
      </h3>

      <p class="mb-3 text-center" v-if="crypto">
        Cours actuel : {{ crypto.current_value }}
      </p>

      <form @submit.prevent="onSubmit" class="offset-md-3 col-6">
        <div class="mb-4">
          <label for="quantity" class="form-label fs-6 mt-3">Quantité </label>
          <input
            name="quantity"
            type="text"
            class="form-control"
            id="quantity"
            aria-describedby="quantity"
            v-model="cryptoToBuy.quantity"
            @keyup="calculateTotal"
          />

          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.cryptoToBuy.quantity.$error"
          >
            {{ v$.cryptoToBuy.quantity.$errors[0].$message }}
          </div>

          <div class="form-label fs-6 mt-3">
            <p>Total à payer : {{ this.total }} €</p>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mr-3">Acheter</button>
        <router-link to="/client/user-wallet">
          <button type="button" class="btn btn-outline-dark m-3">Annuler</button>
        </router-link>
      </form>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import useVuelidate from "@vuelidate/core";
import { required, minValue, maxValue, numeric, integer } from "@vuelidate/validators";

export default {
  name: "BuyCrypto",
  components: {
    Navigation,
  },
  emits: ["buy-new-crypto"],
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  props: {
    userSolde: { type: Number },
    cryptos: { type: Array },
  },
  data() {
    return {
      total: 0,
      crypto: {},
      cryptoToBuy: {
        cryptocurrency_id: 0,
        quantity: 0,
      },
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
          maxValue: maxValue(20),
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
      if (
        window.confirm(
          "Êtes-vous sur de vouloir effectuer cet achat ?"
        )
      ) {

      this.$emit("buy-new-crypto", this.cryptoToBuy);

      this.$router.push("/client/user-wallet");
      }
    },
    calculateTotal() {
      const id_crypto = this.$route.params.id;
      let crypto = this.cryptos.find((c) => c.id == id_crypto);
      this.total = this.cryptoToBuy.quantity * crypto.current_value;
    },
  },
};
</script>
<style></style>
