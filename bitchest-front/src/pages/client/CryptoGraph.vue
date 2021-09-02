<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col-10">
      <h3 class="text-left mt-5 mb-3 text-info mx-5" v-if="loaded">Progression de
            <img :src="`/img/${crypto.logo}`" alt="" width="30" />
         {{crypto.name}} durant les 30 derniers jours</h3>
      <div class="m-5">
        <Vue3ChartJs
          v-if="loaded"
          :id="doughnutChart.id"
          :type="doughnutChart.type"
          :data="CryptoEvolution"
        />
      </div>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import Vue3ChartJs from "@j-t-mcc/vue3-chartjs";
import User from "../../services/User";
export default {
  name: "CryptoGraph",
  components: {
    Navigation,
    Vue3ChartJs,
  },
  props: {
    userSolde: {},
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
            borderColor: "#00fe17",
            label: "Bitcoin",
          },
        ],
      },
      crypto: {},
      loaded: false,
    };
  },
  mounted() {
    const id = this.$route.params.id;
    User.getCryptoEvolution(id)
      .then((r) => {
        this.CryptoEvolution.labels = r.data.dateCryptoEvolution;
        this.CryptoEvolution.datasets[0].data = r.data.valueCryptoEvolution;
        this.CryptoEvolution.datasets[0].label = r.data.crypto.name;
        this.crypto = r.data.crypto;
        this.loaded = true;
        console.log(r.data);
      })
      .catch((error) => console.error(error));
  },
};
</script>
<style></style>
