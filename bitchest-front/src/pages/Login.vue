<template>
  <div class="col-4 mx-auto py-5 mt-5 bg-light p-5 rounded">
    <div
      class="mx-auto col-2 mb-4 border border-2 border-warning text-center p-1 bg-white rounded"
    >
      <i class="fab fa-bitcoin fa-3x text-warning"></i>
    </div>
    <h3 class="text-center mb-4">LOGIN</h3>

    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email :</label>
      <input
        type="email"
        class="form-control"
        id="email"
        aria-describedby="emailHelp"
        v-model="form.email"
      />
      <div id="emailHelp" class="form-text text-danger" v-if="errors.email">
        {{ errors.email[0] }}
      </div>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Password : </label>
      <input
        type="password"
        class="form-control"
        id="exampleInputPassword1"
        v-model="form.password"
      />
      <div id="emailHelp" class="form-text text-danger" v-if="errors.password">
        {{ errors.password[0] }}
      </div>
    </div>

    <button @click.prevent="login" class="btn btn-primary">Login</button>
  </div>
</template>

<script>
import User from "../services/User";

export default {
  name: "Login",
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      errors: [],
    };
  },
  methods: {
    login() {
        if(this.form.email.length != 0 && this.form.password != 0)
      User.login(this.form)

        .then((r) => {
          if (r.statusText == "OK") {
              console.log(r)
            localStorage.setItem("auth", "true");

            if (r.data.status == "admin") {
              localStorage.setItem("admin", "true");
              this.$router.push({
                name: "Dashboardadmin",
              });
            } else {
              localStorage.setItem("admin", "false");
              this.$router.push({
                name: "Dashboardclient",
              });
            }

            return r.data;
          } else {
            return {
              done: false,
            };
          }
        })
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
