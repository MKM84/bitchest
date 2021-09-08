<template>
  <router-view
    :cryptos="cryptos"
    :userList="userList"
    @edit-user="editUser"
    @new-user="newUser"
    @delete-user="deleteUser"
    :alerteContent="alerteContent"
    :showAlerte="showAlerte"
  />
</template>

<script>
import User from "../../services/User";

export default {
  name: "Admin",
  mounted() {
    this.getAllUsers();
    this.getAllAdminCryptos();
  },
  data() {
    return {
      userList: [],
      cryptos: [],
      alerteContent: "",
      showAlerte: false,
      loading: true,
    };
  },
  methods: {
    getAllUsers() {
      User.getAllUsers()
        .then((r) => {
          this.userList = r.data.userList;
        })
        .catch((error) => console.error(error));
    },

    getAllAdminCryptos() {
      User.getAllAdminCryptos()
        .then((r) => {
          this.cryptos = r.data.currencies;
        })
        .catch((error) => console.error(error));
    },
    newUser(user) {
      User.addUser(user)
        .then((r) => {
          if (r.done) {
            this.userList = [...this.userList, user];
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
    editUser(user) {
      User.editUser(user)
        .then((r) => {
          if (r.done) {
            let EditedUser = this.userList.find((u) => u.id == user.id);
            EditedUser.lastname = user.lastname;
            EditedUser.firstname = user.firstname;
            EditedUser.email = user.email;
            EditedUser.status = user.status;
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
    deleteUser(id) {
      let user = this.userList.find((u) => u.id == id);
      if (
        window.confirm(
          `Êtes-vous sur de vouloir supprimmer ${user.firstname} ${user.lastname} ?`
        )
      ) {
        User.deleteUser(id)
          .then((r) => {
            if (r.done) {
              this.userList = this.userList.filter((u) => u.id != id);
            }
          })
          .then(() => {
            this.activeAlerte("La suppression a été effectuée avec succes !");
            this.hideAlerte();
          })
          .catch((error) => console.error(error));
      }
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
