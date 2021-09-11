<template>
  <div class="not-found">
    <div class="col-12 text-center mt-3 d-flex justify-content-center align-items-end">
      <h2 class="text-info"><strong>BitChest</strong></h2>
    </div>

    <h1 class="text-center text-light display-1"><strong>404</strong></h1>
    <p class="text-center text-light">Page non trouvée !</p>
  </div>
</template>

<script>
export default {
  // page 404
  name: "NotFound",
};
</script>
<style scoped>
.not-found {
  background-color: #2c3034;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
</style>
