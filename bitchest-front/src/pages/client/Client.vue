<template>

 <router-view
     :cryptos="cryptos"
     :userSolde="userSolde"
     :wallet="wallet"
     @get-user-infos="getUserInfos"
     :userInfos="userInfos"
     @edit-my-profile="editMyProfile"
 />

</template>

<script>
import User from "../../services/User";


export default {
  name: "Client",
  mounted() {
      this.getAllUserCryptos();
      this.getUserWallet();
      this.getUserInfos();
  },
  components: {

  },
  data() {
    return {
        cryptos: [],
        userSolde: 0,
        wallet: [],
        userInfos: []
    };
  },
  methods: {
    getAllUserCryptos() {
      User.getAllUserCryptos().then((r) => {
        this.cryptos = r.data.currencies;
        this.userSolde = Number(r.data.userSolde);
      }).catch(error=>console.error(error));
    },
      getUserWallet() {
            User.getUserWallet().then((r) => {
        this.wallet = r.data.wallet;
        console.log(r);
      }).catch(error=>console.error(error));
  },
    getUserInfos() {
      User.getUserInfos().then((r) => {
        console.log(r);
        this.userInfos = r.data.userInfos;
      }).catch(error=>console.error(error));
    },
    editMyProfile(user) {
      User.editUserInfos(user)
        .then((r) => {
          if (r.done) {
            this.userInfos.lastname = user.lastname;
            this.userInfos.firstname = user.firstname;
            this.userInfos.email = user.email;
          }
        })
        .then(this.getUserInfos())
        .catch((error) => {
          console.error(error);
        });
    }
  },

};
</script>

<style></style>
