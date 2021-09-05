<template>
  <router-view
    :cryptos="cryptos"
    :userSolde="userSolde"
    @get-user-infos="getUserInfos"
    :userInfos="userInfos"
    @edit-my-profile="editMyProfile"
    :wallet="wallet"
    :userHistory="userHistory"
    @get-cryptos-to-sell="getCryptoToSell"
    :cryptosToSell="cryptosToSell"
    @buy-new-crypto="ByNewCryptos"
    @sell-cryptos="sellCryptos"
    :alerteContent="alerteContent"
    :showAlerte="showAlerte"
  />
</template>

<script>
import User from "../../services/User";

export default {
  name: "Client",
  mounted() {
    this.getAllUserCryptos();
    this.getUserInfos();
    this.getUserWallet();
    this.getUserHistory();
  },
  components: {},
  data() {
    return {
      cryptos: [],
      userSolde: 0,
      userInfos: [],
      wallet: [],
      userHistory: [],
      cryptosToSell: [],
      alerteContent: "",
      showAlerte: false,
    };
  },
  methods: {
    //   get all cryptos
    getAllUserCryptos() {
      User.getAllUserCryptos()
        .then((r) => {
          this.cryptos = r.data.currencies;
          this.userSolde = Number(r.data.userSolde);
        })
        .catch((error) => console.error(error));
    },
    // get user wallet
    getUserWallet() {
      User.getUserWallet()
        .then((r) => {
          this.wallet = r.data.userWallet;
        })
        .catch((error) => console.error(error));
    },
    // get transactions history
    getUserHistory() {
      User.getUserHistory()
        .then((r) => {
          this.userHistory = r.data.historyByCrypto;
        })
        .catch((error) => console.error(error));
    },
    // get one kind of crypto to sell by id crypto
    getCryptoToSell(id) {
      User.getCryptoToSell(id)
        .then((r) => {
          this.cryptosToSell = r.data.cryptosToSellData;
        })
        .catch((error) => console.error(error));
    },
    // get user informations
    getUserInfos() {
      User.getUserInfos()
        .then((r) => {
          this.userInfos = r.data.userInfos;
        })
        .catch((error) => console.error(error));
    },
    // edit conected user innformations
    editMyProfile(user) {
      User.editUserInfos(user)
        .then((r) => {
          if (r.done) {
            this.userInfos.lastname = user.lastname;
            this.userInfos.firstname = user.firstname;
            this.userInfos.email = user.email;
            // confirmation alerte
            this.showAlerte = true;
            this.alerteContent = "Vos informations ont bien été modifiées!";
            this.hideAlerte();
          }
        })
        .then(this.getUserInfos())
        .catch((error) => {
          console.error(error);
        });
    },
    // Buy a crypto
    ByNewCryptos(crypto) {
      User.ByNewCryptos(crypto)
        .then((r) => {
          if (r.done) {
            this.getUserInfos();
            this.getUserWallet();
            this.getUserHistory();
            this.getCryptoToSell();
            this.getAllUserCryptos();
            this.showAlerte = true;
            this.alerteContent = "Votre achat a bien été effectué !";
            this.hideAlerte();
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    // sell a crypto
    sellCryptos(id) {
              if (
        window.confirm(
         " Êtes-vous sur de vouloir effectuer cet achat ?"
        )
      )
{      User.sellCryptos(id)
        .then((r) => {
          if (r.done) {
            this.$router.push("/client/user-wallet");
            this.getUserInfos();
            this.getUserWallet();
            this.getUserHistory();
            this.getCryptoToSell();
            this.getAllUserCryptos();
            // confirmation alerte
            this.showAlerte = true;
            this.alerteContent = "Votre vente a bien été effectuée !";
            this.hideAlerte();
          }
        })
        .catch((error) => {
          console.error(error);
        });
      }
    },
    // hide alerte after 9 sec
    hideAlerte() {
      setTimeout(() => {
        this.showAlerte = false;
        this.alerteContent = "";
      }, 9000);
    },
  },
};
</script>

<style></style>
