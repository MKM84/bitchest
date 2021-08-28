<template>
  <router-view
    :cryptos="cryptos"
    :userList="userList"
    @edit-user="editUser"
    @new-user="newUser"
    @delete-user="deleteUser"
    :key="componentKey"
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
      componentKey: 0,
    };
  },
  methods: {
    getAllUsers() {
      User.getAllUsers().then((r) => {
        this.userList = r.data.userList;
      }).catch(error=>console.error(error));
    },

    getAllAdminCryptos() {
      User.getAllAdminCryptos().then((r) => {
        this.cryptos = r.data.currencies;
      }).catch(error=>console.error(error));
    },
    newUser(user) {
      User.addUser(user)
        .then((r) => {
          if (r.done) {
            this.userList = [...this.userList, user];
          }
        })
        .then(this.$router.push("/admin/user-list"))

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
        .then(this.$router.push("/admin/user-list"))
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
        User.deleteUser(id).then((r) => {
          if (r.done) {
            this.userList = this.userList.filter((u) => u.id != id)
            .catch(error=>console.error(error));
          }
        });
      }
    },
  },
};
</script>

<style></style>
