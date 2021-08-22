<template>
  <div class="home col-4 mx-auto py-5 mt-5 bg-light p-5 rounded">
      <div class="mx-auto col-1 mb-4">
<i class="fas fa-cubes fa-3x"></i>
      </div>
    <h2 class="text-center mb-4">Login</h2>

    <form>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email :</label>
        <input
          type="email"
          class="form-control"
          id="email"
          aria-describedby="emailHelp"
          v-model="form.email"
        />
        <div id="emailHelp" class="form-text text-danger" v-if="errors.email" >
           {{ errors.email[0] }}
        </div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password : </label>
        <input type="password" class="form-control" id="exampleInputPassword1" />
        <div id="emailHelp" class="form-text text-danger" v-if="errors.password">
          {{ errors.password[0] }}
        </div>
      </div>

      <button @click.prevent="login" class="btn btn-primary">Login</button>
    </form>
  </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      form: {
        email: "",
        name: "",
      },
      errors: []
    };
  },
  methods: {
      login() {

      }
  },
};
</script>
