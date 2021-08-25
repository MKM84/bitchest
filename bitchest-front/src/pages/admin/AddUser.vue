<template>
  <div class="row col-12">
    <Navigation :admin="admin" />

    <section class=" offset-md-2 col-4">
      <h3 class="text-left mt-5 mb-3 text-info">Ajouter un utilisateur</h3>

      <form @submit.prevent="addUser">
        <div class="mb-4">
          <!-- Lastname  -->
          <label for="lastname" class="form-label fs-6 mt-3">Nom </label>
          <input
            name="lastname"
            type="text"
            class="form-control"
            id="lastname"
            aria-describedby="lastname"
            v-model="user.lastname"
          />
          <div id="lastnameHelp" class="form-text text-danger" v-if="errors.lastname">
            {{ errors.lastname[0] }}
          </div>
          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.user.lastname.$error"
          >
            {{ v$.user.lastname.$errors[0].$message }}
          </div>
          <!-- Firstname -->
          <label for="firstname" class="form-label fs-6  mt-3">Prénom</label>
          <input
            name="firstname"
            type="text"
            class="form-control"
            id="firstname"
            aria-describedby="firstname"
            v-model="user.firstname"
          />
          <div id="lastnameHelp" class="form-text text-danger" v-if="errors.firstname">
            {{ errors.firstname[0] }}
          </div>
          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.user.firstname.$error"
          >
            {{ v$.user.firstname.$errors[0].$message }}
          </div>

          <!-- email  -->
          <label for="email" class="form-label fs-6  mt-3">Email</label>
          <input
            name="email"
            type="email"
            class="form-control"
            id="email"
            aria-describedby="email"
            v-model="user.email"
          />
          <div id="lastnameHelp" class="form-text text-danger" v-if="errors.email">
            {{ errors.email[0] }}
          </div>
          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.user.email.$error"
          >
            {{ v$.user.email.$errors[0].$message }}
          </div>

          <!-- Password  -->
          <label for="password" class="form-label fs-6  mt-3">Mot de passe</label>
          <input
            name="password"
            type="password"
            class="form-control"
            id="password"
            aria-describedby="password"
            v-model="user.password"
          />
          <div id="lastnameHelp" class="form-text text-danger" v-if="user.password">
            {{ errors.password[0] }}
          </div>
          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.user.password.$error"
          >
            {{ v$.user.password.$errors[0].$message }}
          </div>
        </div>

        <button type="submit" class="btn btn-info mr-3">Ajouter</button>
        <router-link to="/admin/user-list">

        <button type="button" class="btn btn-outline-dark m-3">Annuler</button>
        </router-link>
      </form>
    </section>
  </div>
</template>

<script>
import User from "../../services/User";
import Navigation from "../../components/Navigation.vue";

import useVuelidate from "@vuelidate/core";
import { required, email, minLength } from "@vuelidate/validators";

export default {
  name: "AddUser",
  components: {
    Navigation,
  },
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  data() {
    return {
      user: {
        lastname: "",
        firstame: "",
        email: "",
        password: "",
        status: "",
      },
      admin: true,
      errors: [],
    };
  },
  validations() {
    return {
      user: {
        lastname: {required, minLength: minLength(3)},
        firstname: {required, minLength: minLength(3)},
        email: { required, email },
        password: { required, minLength: minLength(8) },
        status: { required },
      },
    };
  },
  methods: {
    addUser() {
      this.v$.$validate();
      if (this.v$.$error) {
        return false;
      }
      User.addUser(this.form)
      .then(this.$router.push("/admin/user-list"))

    },
  },
};
</script>
<style>
</style>
