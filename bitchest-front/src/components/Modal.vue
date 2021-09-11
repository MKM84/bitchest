<template>
  <div class="modal-ctn">
    <div class="modal-popup rounded border border-info p-3 bg-dark">
      <p class="modal-content bg-dark text-light border-dark text-center mt-3 mb-4">
        {{modalContent}}
      </p>
      <div class="btns-ctn mb-3">
        <button type="button" class="btn btn-secondary text-dark px-5 btn-space" @click="positivAction()">
          Valider
        </button>
        <button type="button" class="btn btn-outline-light px-5" @click="NegativAction()">Annuler</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Modal",
  props: {
    showModal: {
      type: Function,
    },
    modalContent : {
        type: String
    },
    positivAction: {
        type: Function
    },
    NegativAction: {
        type: Function
    }
  },
  methods: {

  }
};
</script>

<style>
.modal-ctn {
    z-index: 1;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  background-color: rgba(33, 37, 41, 0.772);

  position: fixed;
}
.modal-popup {
  width: max-content;
  max-width: 600px;
}

.btns-ctn {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}
</style>
