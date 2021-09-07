<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col ctn-content" v-if="myProfile">

      <form @submit.prevent="onSubmit" class="offset-md-3 col-6 mt-5">
        <div class="mb-4">
          <!-- Lastname  -->
          <label for="lastname" class="form-label fs-6 mt-5 text-light">Nom </label>
          <input
            name="lastname"
            type="text"
            class="form-control"
            id="lastname"
            aria-describedby="lastname"
            v-model="myProfile.lastname"
          />
          <div id="lastnameHelp" class="form-text text-danger" v-if="errors.lastname">
            {{ errors.lastname[0] }}
          </div>
          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.myProfile.lastname.$error"
          >
            {{ v$.myProfile.lastname.$errors[0].$message }}
          </div>
          <!-- Firstname -->
          <label for="firstname" class="form-label fs-6 mt-5 text-light">Prénom</label>
          <input
            name="firstname"
            type="text"
            class="form-control"
            id="firstname"
            aria-describedby="firstname"
            v-model="myProfile.firstname"
          />
          <div id="lastnameHelp" class="form-text text-danger" v-if="errors.firstname">
            {{ errors.firstname[0] }}
          </div>
          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.myProfile.firstname.$error"
          >
            {{ v$.myProfile.firstname.$errors[0].$message }}
          </div>

          <!-- email  -->
          <label for="email" class="form-label fs-6 mt-5 text-light">Email</label>
          <input
            name="email"
            type="email"
            class="form-control"
            id="email"
            aria-describedby="email"
            v-model="myProfile.email"
          />
          <div id="lastnameHelp" class="form-text text-danger" v-if="errors.email">
            {{ errors.email[0] }}
          </div>
          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.myProfile.email.$error"
          >
            {{ v$.myProfile.email.$errors[0].$message }}
          </div>

          <!-- Status  -->
        </div>

        <button type="submit" class="btn btn-secondary px-5 mt-5 btn-space">Valider</button>
        <router-link to="/client/user-wallet">
          <button type="button" class="btn btn-outline-light px-5 mt-5">Annuler</button>
        </router-link>
      </form>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";

import useVuelidate from "@vuelidate/core";
import { required, email, minLength } from "@vuelidate/validators";

export default {
  name: "UserForm",
  components: {
    Navigation,
  },
  emits: ["edit-my-profile"],
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  props: {
    userInfos: {},
    userSolde: { type: Number },
  },
  data() {
    return {
      myProfile: {
        lastname: "",
        firstname: "",
        email: "",
      },

      errors: [],
    };
  },

  mounted() {
    this.myProfile = this.userInfos;
  },
  beforeUpdate() {
    this.myProfile = this.userInfos;
  },

  validations() {
    return {
      myProfile: {
        lastname: { required, minLength: minLength(3) },
        firstname: { required, minLength: minLength(3) },
        email: { required, email },
      },
    };
  },
  methods: {
    onSubmit() {
      this.v$.$validate();
      if (this.v$.$error) {
        return false;
      }
      this.$emit("edit-my-profile", this.myProfile);

      this.$router.push("/client/user-wallet");
    },
  },
};
</script>
<style></style>
