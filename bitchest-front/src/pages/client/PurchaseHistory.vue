<template>
  <div class="row col-12 m-0">
    <Nav-mobile :admin="false" :userInfos="userInfos" />
    <Navigation :admin="false" :userInfos="userInfos" />
    <section class="col ctn-content">
      <Spinner :loading="loading" />

      <div v-if="userHistory && loading == false">
        <table class="table table-dark table-hover mt-4">
          <thead class="thead">
            <tr>
              <th scope="col">Nom</th>
              <th scope="col">Q</th>
              <th scope="col">Date d'achat</th>
              <th scope="col" class="mobile-device">C.A. (€)</th>
              <th scope="col" class="mobile-device">Dépenses</th>
              <th scope="col">État</th>
              <th scope="col" class="mobile-device">Date de vente</th>
              <th scope="col" class="mobile-device">C.V. (€)</th>
              <th scope="col">Gains / Pertes</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="transaction in userHistory" :key="transaction.id">
              <td class="fs-6 pt-3 pb-3 align-middle">
                <img :src="`/img/${transaction.logo}`" alt="" width="30" />
                {{ transaction.name_crypto }}
              </td>
              <td class="fs-6 pt-3 pb-3 align-middle">{{ transaction.quantity }}</td>
              <td class="fs-6 pt-3 pb-3 align-middle">{{ transaction.purchase_date }}</td>
              <td class="fs-6 pt-3 pb-3 align-middle mobile-device">
                {{ transaction.purchase_price }}
              </td>
              <td class="fs-6 pt-3 pb-3 align-middle mobile-device">
                {{ transaction.sum_purchase }}
              </td>
              <td class="align-middle">
                <span
                  :class="`badge ${
                    transaction.state === 0 ? 'bg-warning text-dark' : 'bg-info text-dark'
                  }`"
                >
                  {{ transaction.state === 0 ? "N" : "V" }}</span
                >
              </td>
              <td class="fs-6 pt-3 pb-3 align-middle mobile-device">
                {{ transaction.selling_date }}
              </td>
              <td class="fs-6 pt-3 pb-3 align-middle mobile-device">
                {{ transaction.selling_price }}
              </td>
              <td
                :class="`fs-6 pt-3 pb-3 align-middle ${
                  transaction.balance > 1 ? 'color-green' : 'color-red'
                }`"
              >
                {{ transaction.balance }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</template>

<script>
import Navigation from "../../components/Navigation.vue";
import NavMobile from "../../components/NavMobile.vue";
import Spinner from "../../components/Spinner.vue";

export default {
  name: "PurchaseHistory",
  components: {
    Navigation,
    NavMobile,
    Spinner,
  },
  props: {
    userInfos: { type: Object },
    userHistory: { type: Array },
    loading: { type: Boolean },
  },
};
</script>
<style></style>
