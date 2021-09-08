<template>
  <div class=" col-4 alert alert-light d-flex align-items-center m-5 fixed-alerte" role="alert">
    <svg
      class="bi flex-shrink-0 me-2"
      width="24"
      height="24"
      role="img"
      aria-label="Success:"
    >
      <use xlink:href="#check-circle-fill" />
    </svg>
    <div>{{ alerteContent }}</div>
  </div>
</template>

<script>
export default {
  name: "Alerte",
  props: {
    alerteContent: { type: String },
    showAlerte: { Boolean },
  },
};
</script>

<style>


</style>
