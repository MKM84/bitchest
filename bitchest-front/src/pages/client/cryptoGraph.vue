<template>
  <div class="row col-12">
    <Navigation :admin="false" :userSolde="userSolde" />

    <section class="col">
      <h3 class="text-left mt-5 mb-3 text-info">Progression de Bitcoin depuis un mois </h3>

    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
export default {
  name: "CryptoGraph",
  components: {
    Navigation,
  },
  props: {
    userSolde: { type: Number },
  },

  mounted() {
  },

  data() {
    return {};
  },

  methods: {},
};
</script>
<style></style>
