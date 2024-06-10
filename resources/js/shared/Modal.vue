<template>
  <div class="c-modal-back-drop" v-show="isModalOpen">
    <div class="c-modal-wrapper">
      <div class="c-modal-head-wrapper cf">
        <div v-show="showCloseBtn" class="text-right">
          <AppButton :btnFunc="closeModal" btnStyle="secondary">X</AppButton>
        </div>
        <div class="c-modal-header-wrapper">
          <slot name="c-modal-header"></slot>
        </div>
      </div>
      <div class="c-modal-content-wrapper">
        <slot name="c-modal-content"></slot>
      </div>
    </div>
  </div>
</template>

<script>
import AppButton from "./AppButton.vue";
export default {
  components: {
    AppButton,
  },
  data() {
    return {
      isModalOpen: false,
    };
  },
  props: {
    showModal: {
      type: Boolean,
      default: false,
    },
    showCloseBtn: {
      type: Boolean,
      default: true,
    },
  },
  methods: {
    closeModal() {
      this.isModalOpen = false;
    },
    openModal() {
      this.isModalOpen = true;
    },
  },

  watch: {
    showModal: function (newVal, oldVal) {
      // watch it
      if (newVal) {
        this.openModal();
      } else {
        this.closeModal();
      }
    },
  },
  created() {
    if (this.showModal) {
      this.openModal();
    }
  },
};
</script>
