<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col-10">
      <h3 class="text-left mt-5 mb-3 text-info">Progression de Bitcoin depuis un mois</h3>
      <div class="m-5">
        <Vue3ChartJs
          :id="doughnutChart.id"
          :type="doughnutChart.type"
          :data="framework"
        />
      </div>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import Vue3ChartJs from "@j-t-mcc/vue3-chartjs";

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
      framework: {
        labels: [
          "2021-08-2",
          "2021-08-01",
          "2021-07-30",
          "2021-07-29",
          "2021-07-28",
          "2021-07-27",
          "2021-07-26",
        ],
        datasets: [
          {
            backgroundColor: ["#000"],
            data: [74660.0, 78000.0, 72000.0, 60660.0, 90660.0, 100660.0, 74660.0],
            borderColor: "#00fe17",
            label: "Bitcoin",
          },
        ],
      },
    };
  },
};
</script>
<style></style>
