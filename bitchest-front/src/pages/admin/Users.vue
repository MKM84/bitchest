<template>
  <div class="row col-12 m-0">
    <Nav-mobile :admin="true" :adminInfos="adminInfos" />
    <Navigation :admin="true" :adminInfos="adminInfos" />
    <Modal
      v-if="showModal"
      :showModal="activModal"
      :modalContent="modalContent"
      :positivAction="positivAction"
      :NegativAction="NegativAction"
    />
    <section class="col ctn-content">
      <Spinner :loading="loading" />

      <div :v-if="userList">
        <table class="table mt-4 table-dark table-hover" v-if="loading == false">
          <thead>
            <tr>
              <th scope="col">Nom</th>
              <th scope="col">Prénom</th>
              <th scope="col" class="mobile-device">Email</th>
              <th scope="col" class="mobile-device">Rôle</th>
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
              <td class="fs-6 align-middle mobile-device">
                {{ user.email }}
              </td>
              <td class="fs-6 align-middle mobile-device">
                <span
                  :class="`badge ${
                    user.status === 0 ? 'bg-warning text-dark' : 'bg-light text-dark'
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
                  @click="
                    activModal(
                      `Êtes-vous sûr de vouloir supprimmer  (${user.firstname} ${user.lastname}) ?`,
                      user.id
                    )
                  "
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
import NavMobile from "../../components/NavMobile.vue";
import Modal from "../../components/Modal.vue";
import Alerte from "../../components/Alerte.vue";
import Spinner from "../../components/Spinner.vue";

export default {
  name: "Users",
  components: {
    Navigation,
    NavMobile,
    Alerte,
    Spinner,
    Modal,
  },
  props: {
    userList: { type: Array },
    showAlerte: { type: Boolean },
    alerteContent: { type: String },
    loading: { type: Boolean },
    adminInfos: {
      type: Object,
    },
  },
  data() {
    return {
      showModal: false,
      modalContent: "",
      positivAction: null,
      NegativAction: () => (this.showModal = false),
    };
  },
  emits: ["delete-user"],
  methods: {
    activModal(t, id) {
      this.showModal = true;
      this.modalContent = t;
      this.positivAction = async () => {
        await this.$emit("delete-user", id);
        return (this.showModal = false);
      };
    },
  },
};
</script>
<style></style>
