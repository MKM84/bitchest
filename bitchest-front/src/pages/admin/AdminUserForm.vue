<template>
  <div class="row col-12 m-0">
    <Navigation :admin="true" :adminInfos="adminInfos"/>
    <Nav-mobile :admin="true" :adminInfos="adminInfos"/>

    <section class="col ctn-content">
      <Spinner :loading="loading" />

      <form @submit.prevent="onSubmit" class="mt-3 mb-5" v-if="user">
        <div class="col-sm-6 offset-sm-3 mt-3 mb-5 col-md-6 offset-md-3 mb-4">
          <!-- Lastname  -->
          <label for="lastname" class="form-label fs-6 mt-5 text-light">Nom </label>
          <input
            name="lastname"
            type="text"
            class="form-control"
            id="lastname"
            aria-describedby="lastname"
            v-model="user.lastname"
          />

          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.user.lastname.$error"
          >
            {{ v$.user.lastname.$errors[0].$message }}
          </div>
          <!-- Firstname -->
          <label for="firstname" class="form-label fs-6 mt-5 text-light">Prénom</label>
          <input
            name="firstname"
            type="text"
            class="form-control"
            id="firstname"
            aria-describedby="firstname"
            v-model="user.firstname"
          />

          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.user.firstname.$error"
          >
            {{ v$.user.firstname.$errors[0].$message }}
          </div>

          <!-- email  -->
          <label for="email" class="form-label fs-6 mt-5 text-light">Email</label>
          <input
            name="email"
            type="email"
            class="form-control"
            id="email"
            aria-describedby="email"
            v-model="user.email"
          />
          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.user.email.$error"
          >
            {{ v$.user.email.$errors[0].$message }}
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
            <label class="form-check-label text-light" for="client-radio"> Client </label>
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
            <label class="form-check-label text-light" for="admin-radio"> Admin </label>
          </div>

          <div
            id="lastnameError"
            class="form-text text-danger"
            v-if="v$.user.status.$error"
          >
            {{ v$.user.status.$errors[0].$message }}
          </div>
        </div>
        <div class="text-center mt-5">
        <button type="submit" class="btn btn-secondary text-dark px-5 mt-2 btn-space">
          Valider
        </button>
        <router-link to="/admin/user-list">
          <button type="button" class="btn btn-outline-light px-5 mt-2">Annuler</button>
        </router-link>
        </div>
      </form>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import NavMobile from "../../components/NavMobile.vue"
import useVuelidate from "@vuelidate/core";
import { required, email, minLength, numeric } from "@vuelidate/validators";
import Spinner from "../../components/Spinner.vue";

export default {
  name: "AdminUserForm",
  components: {
    Navigation,
    NavMobile,
    Spinner,
  },
  emits: ["new-user", "edit-user"],
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  props: {
    userList: {
      type: Array,
    },
    loading: { type: Boolean },
    adminInfos: {
      type: Object,
    },
  },
  data() {
    return {
      user: {
        lastname: "",
        firstname: "",
        email: "",
        status: null,
      },

      errors: [],
    };
  },

  beforeUpdate() {
    const id = this.$route.params.id;
    if (id > 0) {
      const user = this.userList.find((u) => u.id == id);
      this.user = user;
    }
  },
  mounted() {
    const id = this.$route.params.id;
    if (id > 0) {
      const user = this.userList.find((u) => u.id == id);
      this.user = user;
    }
  },

  validations() {
    return {
      user: {
        lastname: { required, minLength: minLength(3) },
        firstname: { required, minLength: minLength(3) },
        email: { required, email },
        status: { required, numeric },
      },
    };
  },
  methods: {
    onSubmit() {
      this.v$.$validate();
      if (this.v$.$error) {
        return false;
      }
      const id = this.$route.params.id;

      if (id == 0) {
        this.$emit("new-user", this.user);
      } else {
        this.$emit("edit-user", this.user);
      }

      this.user = {};
      this.$router.push("/admin/user-list");
    },
  },
};
</script>
<style></style>
