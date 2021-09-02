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
      cryptosToSell: []
    };
  },
  methods: {
    getAllUserCryptos() {
      User.getAllUserCryptos()
        .then((r) => {
          this.cryptos = r.data.currencies;
          this.userSolde = Number(r.data.userSolde);
        })
        .catch((error) => console.error(error));
    },
    getUserWallet() {
      User.getUserWallet()
        .then((r) => {
          this.wallet = r.data.userWallet;
          console.log(r);
        })
        .catch((error) => console.error(error));
    },
    getUserHistory() {
      User.getUserHistory()
        .then((r) => {
          this.userHistory = r.data.historyByCrypto;
          console.log(r.data);
        })
        .catch((error) => console.error(error));
    },
    getCryptoToSell(id) {
              User.getCryptoToSell(id)
        .then((r) => {
          this.cryptosToSell = r.data.cryptosToSellData;
          console.log(r.data);
        })
        .catch((error) => console.error(error));
    },
    getUserInfos() {
      User.getUserInfos()
        .then((r) => {
          console.log(r);
          this.userInfos = r.data.userInfos;
        })
        .catch((error) => console.error(error));
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
    },
    ByNewCryptos(crypto) {
          User.ByNewCryptos(crypto)
        .then((r) => {
          if (r.done) {
        this.getUserInfos();
        this.getUserWallet();
        this.getUserHistory();
        this.getCryptoToSell();
        this.getAllUserCryptos();

          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    sellCryptos(id){
              User.sellCryptos(id)
        .then((r) => {
          if (r.done) {
        this.getUserInfos();
        this.getUserWallet();
        this.getUserHistory();
        this.getCryptoToSell();
        this.getAllUserCryptos();
          }
        })
        .catch((error) => {
          console.error(error);
        });
        console.log(id);
    }


  },
};
</script>

<style></style>
