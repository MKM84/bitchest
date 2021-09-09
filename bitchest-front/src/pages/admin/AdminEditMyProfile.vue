<template>
  <div class="row col-12">
    <Navigation :admin="true" :adminInfos="adminInfos"/>

    <section class="col ctn-content">
      <Spinner :loading="loading" />

      <form @submit.prevent="onSubmit" class="offset-md-3 col-6 mt-5" v-if="myProfile">
        <div class="mb-4">
          <!-- Lastname  -->
          <label for="lastname" class="form-label fs-6 mt-4 text-light">Nom </label>
          <input
            name="lastname"
            type="text"
            class="form-control"
            id="lastname"
            aria-describedby="lastname"
            v-model="myProfile.lastname"
          />

          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.myProfile.lastname.$error"
          >
            {{ v$.myProfile.lastname.$errors[0].$message }}
          </div>
          <!-- Firstname -->
          <label for="firstname" class="form-label fs-6 mt-4 text-light">Prénom</label>
          <input
            name="firstname"
            type="text"
            class="form-control"
            id="firstname"
            aria-describedby="firstname"
            v-model="myProfile.firstname"
          />

          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.myProfile.firstname.$error"
          >
            {{ v$.myProfile.firstname.$errors[0].$message }}
          </div>

          <!-- email  -->
          <label for="email" class="form-label fs-6 mt-4 text-light">Email</label>
          <input
            name="email"
            type="email"
            class="form-control"
            id="email"
            aria-describedby="email"
            v-model="myProfile.email"
          />
          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.myProfile.email.$error"
          >
            {{ v$.myProfile.email.$errors[0].$message }}
          </div>

          <!-- Status  -->


        <!-- password  -->

           <label for="password" class="form-label fs-6 mt-4 text-light"
            >Nouveau mot de passe</label
          >
          <input
            name="password"
            type="password"
            class="form-control"
            id="password"
            aria-describedby="password"
            v-model="myProfile.password"
          />

          <div
            id="passwordError"
            class="form-text text-danger"
            v-if="v$.myProfile.password.$error"
          >
            {{ v$.myProfile.password.$errors[0].$message }}
          </div>

          <label for="repeatPassword" class="form-label fs-6 mt-4 text-light"
            >Confirmer le mot passe</label
          >
          <input
            name="repeatPassword"
            type="password"
            class="form-control"
            id="repeatPassword"
            aria-describedby="repeatPassword"
            v-model="myProfile.repeatPassword"
          />

          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.myProfile.repeatPassword.$error"
          >
            {{ v$.myProfile.repeatPassword.$errors[0].$message }}
          </div>

          <div class="form-check mt-3">
            <input
              class="form-check-input"
              type="radio"
              name="client"
              id="client-radio"
              value="1"
              v-model="myProfile.status"
            />
            <label class="form-check-label text-light" for="client-radio"> Client </label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              name="admin"
              id="admin-radio"
              value="0"
              v-model="myProfile.status"
            />
            <label class="form-check-label text-light" for="admin-radio"> Admin </label>
          </div>

          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.myProfile.status.$error"
          >
            {{ v$.myProfile.status.$errors[0].$message }}
          </div>
        </div>



        <button type="submit" class="btn btn-secondary text-dark px-5 mt-5 btn-space">
          Valider
        </button>
        <router-link to="/admin/user-list">
          <button type="button" class="btn btn-outline-light px-5 mt-5">Annuler</button>
        </router-link>
      </form>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";

import useVuelidate from "@vuelidate/core";
import { required, email, minLength, sameAs, alphaNum } from "@vuelidate/validators";
import Spinner from "../../components/Spinner.vue";

export default {
  name: "AdminEditMyProfile",
  components: {
    Navigation,
    Spinner,
  },
  emits: ["admin-edit-my-profile"],
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  props: {
    loading: { type: Boolean },
    adminInfos: {
      type: Object,
    },
  },
  data() {
    return {
      myProfile: {
        lastname: "",
        firstname: "",
        email: "",
        password: "",
        status : ""
      },


    };
  },
  mounted() {
this.myProfile = this.adminInfos;
  },
    beforeUpdate() {
this.myProfile = this.adminInfos;
  },

  validations() {
    return {
      myProfile: {
        lastname: { required, minLength: minLength(3) },
        firstname: { required, minLength: minLength(3) },
        email: { required, email },
        password: { alphaNum },
        repeatPassword: {
          sameAsPassword: sameAs(this.myProfile.password),
        },
        status : {required},
      },
    };
  },
  methods: {
    onSubmit() {
      this.v$.$validate();
      if (this.v$.$error) {
        return false;
      }
        this.$emit("admin-edit-my-profile", this.myProfile);
      this.myProfile = {};
      this.$router.push("/admin/user-list");
    },
  },
};
</script>
<style></style>
