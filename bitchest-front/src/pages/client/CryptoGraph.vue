<template>
  <div class="row col-12 m-0">
    <Nav-mobile :admin="false" :userInfos="userInfos" />
    <Navigation :admin="false" :userInfos="userInfos" />
    <section class="col ctn-content">
      <Spinner :loading="!loaded" />
      <div v-if="loaded">
        <div class="text-end col-11 mt-5">
          <router-link :to="'/client/buy-crypto/' + crypto.id">
            <button class="btn btn-secondary text-dark">Acheter</button>
          </router-link>
        </div>
        <h3 class="text-center mb-3 text-light">
          <div class="mb-2">
            <img :src="`/img/${crypto.logo}`" alt="" width="30" />
          </div>
          {{ crypto.name }}
        </h3>

        <div class="offset-md-1 col-10 mb-5">
          <!-- Chart component  -->
          <Vue3ChartJs
            v-if="loaded"
            :id="doughnutChart.id"
            :type="doughnutChart.type"
            :data="CryptoEvolution"
          />
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import NavMobile from "../../components/NavMobile.vue";
import Vue3ChartJs from "@j-t-mcc/vue3-chartjs";
import Spinner from "../../components/Spinner.vue";
import User from "../../services/User";
export default {
  name: "CryptoGraph",
  components: {
    Navigation,
    Vue3ChartJs,
    NavMobile,
    Spinner,
  },
  props: {
    userInfos: { type: Object },
    loading: { type: Boolean },
  },
  setup() {
    const doughnutChart = {
      id: "doughnut",
      type: "line",
    };
    return {
      doughnutChart,
    };
  },
  data() {
    return {
      CryptoEvolution: {
        labels: [],
        datasets: [
          {
            backgroundColor: ["#000"],
            data: [],
            borderColor: "#0dcaf0",
            label: "Bitcoin",
          },
        ],
      },
      crypto: {},
      loaded: false,
    };
  },
  mounted() {
    //   get selected crypto evolution
    const id = this.$route.params.id;
    User.getCryptoEvolution(id)
      .then((r) => {
        this.CryptoEvolution.labels = r.data.dateCryptoEvolution;
        this.CryptoEvolution.datasets[0].data = r.data.valueCryptoEvolution;
        this.CryptoEvolution.datasets[0].label = r.data.crypto.name;
        this.crypto = r.data.crypto;
        this.loaded = true;
      })
      .catch((error) => console.error(error));
  },
};
</script>
<style></style>
