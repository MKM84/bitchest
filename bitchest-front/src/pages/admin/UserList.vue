<template>
  <div class="row col-12">
    <Navigation :admin="admin" />

    <section class="col">
      <h3 class="text-left mt-5 mb-3 text-info">Les clients</h3>
      <table class="table">
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
            <td class="fs-6">
              {{ user.lastname }}
            </td>
            <td class="fs-6">
              {{ user.firstname }}
            </td>
            <td class="fs-6">
              {{ user.email }}
            </td>
            <td class="fs-6">
                <span :class="`badge ${ user.status === 0 ? 'bg-info text-dark' : 'bg-light text-dark'}`">{{ user.status === 0 ? 'Admin' : 'Client' }}</span>

            </td>
            <td class="fs-6">
             <button type="button" class="btn text-secondary"><i class="fas fa-edit"></i></button>
            </td>
            <td class="fs-6">
           <button type="button" class="btn text-danger"><i class="fas fa-trash-alt"></i></button>
            </td>

          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
import User from "../../services/User";
import Navigation from "../../components/Navigation.vue";
export default {
  name: "UserList",
  components: {
    Navigation,
  },
  mounted() {
    this.getAllUsers();
  },
  data() {
    return {
      userList: {},
      admin: true,
    };
  },
  methods: {
    getAllUsers() {
      User.getAllUsers().then((r) => {
        this.userList = r.data.userList;
        console.log(this.userList);
      });
    },
  },
};
</script>
<style>

</style>
