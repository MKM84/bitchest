<template>
  <div class="login-ctn">
      <div class="login col-lg-4 offset-lg-4 col-xl-4  offset-xl-4 col-md-4 offset-md-4 col-sm-8 offset-sm-2 col-10 offset-1 d-flex align-items-center justify-content-end">
        <div class="col-12 text-center d-flex justify-content-center align-items-end mb-4">
          <h2 class="text-info"><strong>BitChest</strong></h2>
        </div>
        <div class="col-10 p-0 col-sm p-0 col-lg p-0 col-xl p-0 col-md p-0 mx-auto rounded">
          <form @submit.prevent="onLogin">
            <div class="mb-4">
              <label for="email" class="form-label fs-5 text-light">Email* </label>
              <input
                name="email"
                type="email"
                class="form-control"
                id="email"
                aria-describedby="emailHelp"
                v-model="form.email"
                autofocus
                autocomplete="off"
              />
              <div id="emailHelp" class="form-text text-danger" v-if="errors.email">
                {{ errors.email[0] }}
              </div>
              <div id="emailError" class="form-text text-danger" v-if="v$.form.email.$error">
                {{ v$.form.email.$errors[0].$message }}
              </div>
            </div>
            <div class="mb-4">
              <label for="password" class="form-label fs-5 text-light">Password* </label>
              <input
                name="password"
                type="password"
                class="form-control"
                id="exampleInputPassword1"
                v-model="form.password"
                autocomplete="off"
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
            <div class="text-center">
              <button
                type="submit"
                class="btn btn-secondary text-dark text-center mt-3 fs-5 px-4"
              >
                Login
              </button>
            </div>
          </form>
        </div>
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
  background-color: #212529;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-top: 5rem;
  padding: 3rem;
  border-radius: 30px;
}
.login-ctn {
    height: 100vh;

}
</style>
