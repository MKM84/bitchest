<template>
  <div class="row col-12">
    <aside class="col-2 bg-light">
      <div class="col-12 text-center mt-5 d-flex justify-content-center align-items-end">
        <i class="fab fa-bitcoin fa-3x text-warning"></i>
        <h3 class="logo">itChest</h3>
      </div>
      <div class="col-12  mt-5">
        <a class="text-center d-block  p-2 m-3 nav-link fs-6 text-dark rounded border border-dark aside-link" href="#">Utilisateurs</a>
        <a class="text-center d-block  p-2 m-3 nav-link fs-6 text-dark rounded border border-dark aside-link" href="#">Cryptomonnaies</a>
      </div>
    </aside>
    <section class="col-10">
      <h4 class="text-center mt-5 mb-5">Liste des cryptomonnaies</h4>
      <table class="table">
        <thead>
          <tr class="table-light">
            <th scope="col">Nom</th>
            <th scope="col">Cours actuel</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Mark</td>
            <td>Otto</td>
          </tr>
          <tr>
            <td>Jacob</td>
            <td>Thornton</td>
          </tr>
          <tr>
            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>
            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>

            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>

            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>

            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>

            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>

            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>

            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>

            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>

            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>

            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>

            <td>twitter</td>
            <td>twitter</td>
          </tr>
          <tr>

            <td>twitter</td>
            <td>twitter</td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
export default {
  name: "Dashboardclient",
};
</script>
<style scooped>
body {
  position: relative;
}
aside {
  position: sticky;
  top: 0;
  width: 100%;
  height: 100vh;
}
.logo {
  margin-top: 0px;
  margin-left: -12px;
  margin-bottom: 5px;
}

</style>
