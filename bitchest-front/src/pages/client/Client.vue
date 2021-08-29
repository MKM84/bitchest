<template>

 <router-view
     :cryptos="cryptos"
     :userSolde="userSolde"
 />

</template>

<script>
import User from "../../services/User";


export default {
  name: "Client",
  mounted() {
      this.getAllUserCryptos();
  },
  components: {

  },
  data() {
    return {
        cryptos: [],
        userSolde: 0
    };
  },
  methods: {
    getAllUserCryptos() {
      User.getAllUserCryptos().then((r) => {
        this.cryptos = r.data.currencies;
        this.userSolde = Number(r.data.userSolde);
        console.log(r);
      }).catch(error=>console.error(error));
    }
  },
};
</script>

<style></style>
