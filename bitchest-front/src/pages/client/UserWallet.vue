<template>
  <div class="row col-12 m-0">
    <Nav-mobile :admin="false" :userInfos="userInfos" />
    <Navigation :admin="false" :userInfos="userInfos" />
    <section class="col ctn-content">
      <Spinner :loading="loading" />
      <div v-if="wallet">
        <table class="table table-dark table-hover mt-4" v-if="loading == false">
          <thead class="thead">
            <tr>
              <th scope="col">Cryptomonnaies</th>
              <th scope="col">Quantité</th>
              <th scope="col" class="mobile-device">Dépenses</th>
              <th scope="col">C.A.(€)</th>
              <th scope="col">Vendre</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="wall in wallet" :key="wall.id">
              <td class="align-middle p-3">
                <img :src="`/img/${wall.logo_crypto}`" alt="" width="30" />
                {{ wall.name_crypto }}
              </td>
              <td class="align-middle">{{ wall.quantity_sum }}</td>
              <td class="align-middle">{{ wall.prices_sum }}</td>
              <td class="align-middle mobile-device">{{ wall.current_value }}</td>
              <td class="align-middle">
                <router-link :to="'/client/user-sell-crypto/' + wall.id_crypto">
                  <button class="btn btn-primary text-info">
                    <i class="fas fa-money-bill-wave"></i>
                  </button>
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <Alerte v-if="showAlerte" :showAlerte="showAlerte" :alerteContent="alerteContent" />
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import NavMobile from "../../components/NavMobile.vue";
import Alerte from "../../components/Alerte.vue";
import Spinner from "../../components/Spinner.vue";

export default {
  name: "UserWallet",
  components: {
    Navigation,
    NavMobile,
    Alerte,
    Spinner,
  },
  props: {
    wallet: { type: Array },
    userInfos: { type: Object },
    showAlerte: { type: Boolean },
    alerteContent: { type: String },
    loading: { type: Boolean },
  },
};
</script>
<style></style>
