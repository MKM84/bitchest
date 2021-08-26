<template>
  <div class="row col-12">
    <Navigation :admin="admin" />

    <section class="offset-md-2 col-4">
      <h3 class="text-left mt-5 mb-3 text-info">Ajouter un utilisateur</h3>

      <form @submit.prevent="addNewUser">
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
          <label for="firstname" class="form-label fs-6 mt-3">Prénom</label>
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
          <label for="email" class="form-label fs-6 mt-3">Email</label>
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
          <label for="password" class="form-label fs-6 mt-3">Mot de passe</label>
          <input
            name="password"
            type="text"
            class="form-control"
            id="password"
            aria-describedby="password"
            v-model="user.password"
          />
          <div id="lastnameHelp" class="form-text text-danger" v-if="errors.password">
            {{ errors.password[0] }}
          </div>
          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.user.password.$error"
          >
            {{ v$.user.password.$errors[0].$message }}
          </div>
          <!-- Status  -->


          <div class="form-check mt-3">
            <input
              class="form-check-input"
              type="radio"
              name="client"
              id="client-radio"
              value="1"
              v-model="user.status"
            />
            <label class="form-check-label" for="client-radio"> Client </label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              name="admin"
              id="admin-radio"
              value="0"
              v-model="user.status"
            />
            <label class="form-check-label" for="admin-radio"> Admin </label>
          </div>
               <div id="lastnameHelp" class="form-text text-danger" v-if="errors.status">
            {{ errors.status[0] }}
          </div>
          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.user.status.$error"
          >
            {{ v$.user.status.$errors[0].$message }}
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
import { required, email, minLength, numeric } from "@vuelidate/validators";

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
        firstname: "",
        email: "",
        password: "",
        status: null,
      },
      admin: true,
      errors: [],
    };
  },
  validations() {
    return {
      user: {
        lastname: { required, minLength: minLength(3) },
        firstname: { required, minLength: minLength(3) },
        email: { required, email },
        password: { required },
        status: { required, numeric },
      },
    };
  },
  methods: {
    addNewUser() {
      this.v$.$validate();
      if (this.v$.$error) {
        return false;
      }
      User.addUser(this.user)
        .then(this.$router.push("/admin/user-list"))
        .catch((error) => {
          console.log(error);
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          }
        });
    },
  },
};
</script>
<style></style>
