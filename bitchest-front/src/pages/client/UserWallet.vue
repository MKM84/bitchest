<template>
  <div class="row col-12">
    <Navigation :admin="false" />

    <section class="col">
      <h3 class="text-left mt-5 mb-3 text-info">user Walet</h3>

    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
export default {
  name: "UserWallet",
  components: {
    Navigation,
  },
  props: {
  },
  mounted() {

  },
  data() {
    return {

    };
  },
  methods: {

  },
};
</script>
<style></style>
