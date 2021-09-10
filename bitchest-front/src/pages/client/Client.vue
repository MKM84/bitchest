<template>
  <router-view
    :cryptos="cryptos"
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
    :loading="loading"
    @sell-all-by-crypto="sellAllByCrypto"
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
      userInfos: {},
      wallet: [],
      userHistory: [],
      cryptosToSell: [],
      alerteContent: "",
      showAlerte: false,
      loading: true,
    };
  },
  methods: {
    //   get all cryptos
    getAllUserCryptos() {
      this.loading = true;
      User.getAllUserCryptos()
        .then((r) => {
          this.cryptos = r.data.currencies;
          this.loading = false;
        })
        .catch((error) => console.error(error));
    },
    // get user wallet
    getUserWallet() {
      this.loading = true;
      User.getUserWallet()
        .then((r) => {
          this.wallet = r.data.userWallet;
          this.loading = false;

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
      this.loading = true;
      User.getCryptoToSell(id)
        .then((r) => {
          this.cryptosToSell = r.data.cryptosToSellData;
          this.loading = false;

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
            this.activeAlerte("Vos informations ont bien été modifiées !");
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
      this.loading = true;
      User.ByNewCryptos(crypto)
        .then((r) => {
          if (r.done) {
            this.getUserInfos();
            this.getUserWallet();
            this.getUserHistory();
            this.getCryptoToSell();
            this.getAllUserCryptos();
            this.loading = false;

          }
        })
        .then(() => {
          this.activeAlerte("Votre achat a bien été effectué !");
          this.hideAlerte();
        })
        .catch((error) => {
          console.error(error);
        });
    },
    // sell a crypto
    sellCryptos(id) {
      if (window.confirm(" Êtes-vous sur de vouloir effectuer cette vente ?")) {
        this.loading = true;
        User.sellCryptos(id)
          .then((r) => {
            if (r.done) {
              this.$router.push("/client/user-wallet");
              this.getUserInfos();
              this.getUserWallet();
              this.getUserHistory();
              this.getCryptoToSell();
              this.getAllUserCryptos();
              this.loading = false;

            }
          })
          .then(() => {
            this.activeAlerte("Votre vente a bien été effectuée !");
            this.hideAlerte();
          })
          .catch((error) => {
            console.error(error);
          });
      }
    },
    sellAllByCrypto(id) {
      if (window.confirm(" Êtes-vous sur de vouloir tout vendre ?")) {
        this.loading = true;
        console.log(id)
        User.sellAllByCrypto(id)
          .then((r) => {
            if (r.done) {
              this.$router.push("/client/user-wallet");
              this.getUserInfos();
              this.getUserWallet();
              this.getUserHistory();
              this.getCryptoToSell();
              this.getAllUserCryptos();
              this.loading = false;
            }
          })
          .then(() => {
            this.activeAlerte("Votre vente a bien été effectuée !");
            this.hideAlerte();
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
