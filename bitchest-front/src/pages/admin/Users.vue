<template>
  <div class="row col-12">
    <Navigation :admin="true" />

    <section class="col ctn-content">
      <h3 class="text-center mt-5 mb-5 text-dark"><strong>Les clients</strong></h3>
      <Alerte v-if="showAlerte" :showAlerte="showAlerte" :alerteContent="alerteContent" />
      <table class="table" :v-if="userList">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Email</th>
            <th scope="col">Rôle</th>
            <th scope="col">Modifier</th>
            <th scope="col">Supprimer</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in userList" :key="user.id">
            <td class="fs-6 align-middle">
              {{ user.lastname }}
            </td>
            <td class="fs-6 align-middle">
              {{ user.firstname }}
            </td>
            <td class="fs-6 align-middle">
              {{ user.email }}
            </td>
            <td class="fs-6 align-middle">
              <span
                :class="`badge ${
                  user.status === 0 ? 'bg-warning text-dark' : 'bg-light text-dark'
                }`"
                >{{ user.status === 0 ? "Admin" : "Client" }}</span
              >
            </td>
            <td class="fs-6 align-middle">
              <router-link :to="'/admin/user-form/' + user.id">
                <button type="button" class="btn text-primary">
                  <i class="fas fa-edit"></i>
                </button>
              </router-link>
            </td>
            <td class="fs-6 align-middle">
              <button
                @click="$emit('delete-user', user.id)"
                type="button"
                class="btn text-danger"
              >
                <i class="fas fa-trash-alt"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import Alerte from "../../components/Alerte.vue";

export default {
  name: "Users",
  components: {
    Navigation,
    Alerte,
  },
  props: {
    userList: { type: Array },
    userSolde: { type: Number },
    showAlerte: { type: Boolean },
    alerteContent: { type: String },
  },
  emits: ["delete-user"],
};
</script>
<style></style>
