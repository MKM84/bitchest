<template>
  <router-view
    :cryptos="cryptos"
    :userList="userList"
    @edit-user="editUser"
    @new-user="newUser"
    @delete-user="deleteUser"
    :alerteContent="alerteContent"
    :showAlerte="showAlerte"
    :loading="loading"
    :adminInfos="adminInfos"
    @admin-edit-my-profile="AdminEditMyProfile"
  />
</template>

<script>
import User from "../../services/User";

export default {
  name: "Admin",
  mounted() {
    this.getAllUsers();
    this.getAllAdminCryptos();
    this.getAdminInfos();
  },
  data() {
    return {
      userList: [],
      cryptos: [],
      alerteContent: "",
      showAlerte: false,
      loading: true,
      adminInfos: {},
    };
  },
  methods: {
    //   get user liste
    getAllUsers() {
      this.loading = true;
      User.getAllUsers()
        .then((r) => {
          this.userList = r.data.userList;
          this.loading = false;
        })
        .catch((error) => console.error(error));
    },
    // get all cryptos
    getAllAdminCryptos() {
      this.loading = true;
      User.getAllAdminCryptos()
        .then((r) => {
          this.cryptos = r.data.currencies;
          this.loading = false;
        })
        .catch((error) => console.error(error));
    },
    // add user
    newUser(user) {
      this.loading = true;
      User.addUser(user)
        .then((r) => {
          if (r.done) {
            this.userList = [...this.userList, user];
            this.loading = false;
          }
        })
        .then(() => {
          this.activeAlerte(user.lastname + " a été ajouté(e) avec succes !");
          this.hideAlerte();
        })
        .then(this.getAllUsers())
        .catch((error) => {
          console.error(error);
        });
    },
    // edit user
    editUser(user) {
      this.loading = true;
      User.editUser(user)
        .then((r) => {
          if (r.done) {
            let EditedUser = this.userList.find((u) => u.id == user.id);
            EditedUser.lastname = user.lastname;
            EditedUser.firstname = user.firstname;
            EditedUser.email = user.email;
            EditedUser.status = user.status;
            this.loading = false;
          }
        })
        .then(() => {
          this.activeAlerte("Les modifications ont été effectuées avec succes !");
          this.hideAlerte();
        })
        .then(this.getAllUsers())
        .catch((error) => {
          console.error(error);
        });
    },
    // delete user
    deleteUser(id) {
      this.loading = true;
      User.deleteUser(id)
        .then((r) => {
          if (r.done) {
            this.userList = this.userList.filter((u) => u.id != id);
            this.loading = false;
          }
        })
        .then(() => {
          this.activeAlerte("La suppression a été effectuée avec succes !");
          this.hideAlerte();
        })
        .catch((error) => console.error(error));
    },
    // get admin's informations
    getAdminInfos() {
      User.getAdminInfos()
        .then((r) => {
          this.adminInfos = r.data.adminInfos;
        })
        .catch((error) => console.error(error));
    },
    AdminEditMyProfile(admin) {
      this.loading = true;
      User.AdminEditMyProfile(admin)
        .then((r) => {
          if (r.done) {
            this.getAdminInfos();
            this.loading = false;
          }
        })
        .then(() => {
          this.activeAlerte("Vos informations ont été modifiées avec succes !");
          this.hideAlerte();
        })
        .then(this.getAllUsers())
        .catch((error) => {
          console.error(error);
        });
    },
    // hide alerte after 9 sec
    hideAlerte() {
      setTimeout(() => {
        this.showAlerte = false;
        this.alerteContent = "";
      }, 9000);
    },
    // show alerte
    activeAlerte(t) {
      setTimeout(() => {
        this.showAlerte = true;
        this.alerteContent = t;
      }, 1000);
    },
  },
};
</script>

<style></style>
