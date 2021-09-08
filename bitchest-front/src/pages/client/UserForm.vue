<template>
  <div class="row col-12">
    <Navigation :admin="false" :userInfos="userInfos" />

    <section class="col ctn-content" v-if="myProfile">
      <Spinner :loading="loading" />

      <form
        @submit.prevent="onSubmit"
        class="offset-md-3 col-6 mt-5"
        v-if="loading == false"
      >
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
          <label for="firstname" class="form-label fs-6 mt-4 text-light">Prénom</label>
          <input
            name="firstname"
            type="text"
            class="form-control"
            id="firstname"
            aria-describedby="firstname"
            v-model="myProfile.firstname"
          />
          <div id="firstnameHelp" class="form-text text-danger" v-if="errors.firstname">
            {{ errors.firstname[0] }}
          </div>
          <div
            id="firstnameError"
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
          <div id="emailHelp" class="form-text text-danger" v-if="errors.email">
            {{ errors.email[0] }}
          </div>
          <div
            id="emailError"
            class="form-text text-danger"
            v-if="v$.myProfile.email.$error"
          >
            {{ v$.myProfile.email.$errors[0].$message }}
          </div>

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
          <div id="passwordHelp" class="form-text text-danger" v-if="errors.password">
            {{ errors.password[0] }}
          </div>
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
        </div>

        <button type="submit" class="btn btn-secondary text-dark px-5 mt-4 btn-space">
          Valider
        </button>
        <router-link to="/client/user-wallet">
          <button type="button" class="btn btn-outline-light px-5 mt-4">Annuler</button>
        </router-link>
      </form>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import Spinner from "../../components/Spinner.vue";
import useVuelidate from "@vuelidate/core";
import { required, email, minLength, sameAs, alphaNum } from "@vuelidate/validators";

export default {
  name: "UserForm",
  components: {
    Navigation,
    Spinner,
  },
  emits: ["edit-my-profile"],
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  props: {
    userInfos: { type: Object },
    loading: { type: Boolean },
  },
  data() {
    return {
      myProfile: {
        lastname: "",
        firstname: "",
        email: "",
        password: "",
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
        password: { alphaNum },
        repeatPassword: {
          sameAsPassword: sameAs(this.myProfile.password),
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
      this.$emit("edit-my-profile", this.myProfile);

      this.$router.push("/client/user-wallet");
    },
  },
};
</script>
<style></style>
