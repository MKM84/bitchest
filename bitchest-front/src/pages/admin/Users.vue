<template>
  <div class="row col-12">
    <Navigation :admin="true" />

    <section class="col ctn-content">
      <Spinner :loading="loading" />

      <div :v-if="userList">
          <table class="table mt-4 table-dark table-hover" v-if="loading == false">
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
                      user.status === 0 ? 'bg-info text-dark' : 'bg-light text-dark'
                    }`"
                    >{{ user.status === 0 ? "Admin" : "Client" }}</span
                  >
                </td>
                <td class="fs-6 align-middle">
                  <router-link :to="'/admin/user-form/' + user.id">
                    <button type="button" class="btn color-success">
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
      </div>
      <Alerte v-if="showAlerte" :showAlerte="showAlerte" :alerteContent="alerteContent" />

    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import Alerte from "../../components/Alerte.vue";
import Spinner from "../../components/Spinner.vue";

export default {
  name: "Users",
  components: {
    Navigation,
    Alerte,
    Spinner,
  },
  props: {
    userList: { type: Array },
    userSolde: { type: Number },
    showAlerte: { type: Boolean },
    alerteContent: { type: String },
    loading: { type: Boolean },

  },
  emits: ["delete-user"],
};
</script>
<style></style>
