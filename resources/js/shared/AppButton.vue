<template>
  <button
    v-show="!noBtnStyle"
    :title="btnTitle"
    :type="btnType"
    :class="{
      'hide-on-all-screen': hideBtn,
      'btn-full': fullBtn,
      'btn-muted': btnStyle === 'muted',
      'primary-btn': btnStyle === 'primary',
      'btn-primary': btnStyle === 'primary2',
      'btn-danger': btnStyle === 'danger',
      'btn-default': btnStyle === 'default',
      'btn-secondary': btnStyle === 'secondary',
      'btn-success': btnStyle === 'success',
      'btn-warning': btnStyle === 'warn',
      [appBtnData.defaultClassName]: true,
    }"
    @click="btnFunc"
  >
    <slot />
  </button>
  <button
    :class="customClassObj != null ? customClassObj : customClass"
    v-show="noBtnStyle"
    @click="btnFunc"
  >
    <slot />
  </button>
</template>

<script setup>
import { reactive } from "vue";

const props = defineProps({
  noBtnStyle: {
    type: Boolean,
    default: false,
  },
  btnStyle: {
    type: String,
    default: "default",
  },
  btnType: {
    type: String,
    default: "button",
  },

  btnTitle: {
    type: String,
    default: "",
  },

  btnFunc: {
    type: Function,
    default: null,
  },

  fullBtn: {
    type: Boolean,
    default: false,
  },
  hideBtn: {
    type: Boolean,
    default: false,
  },

  customClass: {
    type: String,
    default: "",
  },
  customClassObj: {
    type: Object,
    default: null,
  },
});

const appBtnData = reactive({
  defaultClassName: "no-border-radius btn shadow-none " + props.customClass,
});
</script>
