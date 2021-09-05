<template>
  <div class="login col-8 offset-2">
    <div class="col-12 text-center d-flex justify-content-center align-items-end">
      <img src="img/bitchest_logo.png" alt="" width="200" />
    </div>
    <div
      class="col-10 col-sm-10 col-lg-6 col-md-8 col-xl-10 mx-auto py-5 mt-3 p-5 rounded"
    >
      <form @submit.prevent="onLogin">
        <div class="mb-4">
          <h4 class="text-center mb-4">Login</h4>
          <label for="email" class="form-label fs-5">Email* </label>
          <input
            name="email"
            type="email"
            class="form-control"
            id="email"
            aria-describedby="emailHelp"
            v-model="form.email"
            autofocus
          />
          <div id="emailHelp" class="form-text text-danger" v-if="errors.email">
            {{ errors.email[0] }}
          </div>
          <div id="emailError" class="form-text text-danger" v-if="v$.form.email.$error">
            {{ v$.form.email.$errors[0].$message }}
          </div>
        </div>
        <div class="mb-4">
          <label for="password" class="form-label fs-5">Password* </label>
          <input
            name="password"
            type="password"
            class="form-control"
            id="exampleInputPassword1"
            v-model="form.password"
          />
          <div id="emailHelp" class="form-text text-danger" v-if="errors.password">
            {{ errors.password[0] }}
          </div>
          <div
            id="passError"
            class="form-text text-danger"
            v-if="v$.form.password.$error"
          >
            {{ v$.form.password.$errors[0].$message }}
          </div>
        </div>

        <button type="submit" class="btn btn-primary fs-5">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
import useVuelidate from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";

export default {
  name: "Login",
  props: { errors: {} },
  setup() {
    return {
      v$: useVuelidate(),
    };
  },
  emits: ["log-in"],
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
    };
  },
  validations() {
    return {
      form: {
        email: { required, email },
        password: { required },
      },
    };
  },
  methods: {
    onLogin() {
      this.v$.$validate();
      if (this.v$.$error) {
        return false;
      }
      this.$emit("log-in", this.form);
    },
  },
};
</script>
<style scoped>
.login {
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-top: 6rem;
  padding: 3rem;
  border-radius: 30px;
}
</style>
