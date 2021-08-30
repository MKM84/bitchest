<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="offset-md-2 col-4" >
      <h3 class="text-left mt-5 mb-3 text-info">Acheter - Bitcoin</h3>
         <p>Cours actuel : 55555 €</p>

      <form @submit.prevent="onSubmit">
        <div class="mb-4">
          <label for="quantity" class="form-label fs-6 mt-3">Quantité </label>
          <input
            name="quantity"
            type="text"
            class="form-control"
            id="quantity"
            aria-describedby="quantity"
            v-model="quantity"
            @keyup="calculateTotal"
          />

          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.quantity.$error"
          >
            {{ v$.quantity.$errors[0].$message }}
          </div>

          <div class="form-label fs-6 mt-3">
          <p>Total : {{this.total}} €</p>

          </div>

        </div>

        <button type="submit" class="btn btn-info mr-3">Acheter</button>
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
import { required, numeric, minValue, maxValue, integer} from "@vuelidate/validators";

export default {
  name: "UserForm",
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
  },
  data() {
    return {
        quantity : 0,
        total: 0
    };
  },

  mounted() {
  },


  validations() {
    return {
      quantity: { required, numeric, minValue:minValue(1), maxValue: maxValue(10), integer},
      total: {}
    };
  },
  methods: {
    onSubmit() {
      this.v$.$validate();
      if (this.v$.$error) {
        return false;
      }
        this.$emit("ByNewCryptos", this.quantity);

      this.$router.push("/client/cryptos");
    },
    calculateTotal() {
        this.total = this.quantity*4
    }
  },
};
</script>
<style></style>
