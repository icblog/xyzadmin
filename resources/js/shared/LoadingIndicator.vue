<template>
  <div v-if="dot" :class="classNameValue"><div class="fa-3x">..........</div></div>
  <div v-if="!dot" :class="classNameValue">
    <div class="fa-3x"><i class="fas fa-spinner fa-spin"></i></div>
    <p>Please wait...</p>
  </div>
</template>

<script setup>
import {ref } from "vue";

let classNameValue = ref("loader");

if (props.position !== null && props.position === "full-page") {
  classNameValue.value = `${classNameValue.value} full-page-loader`;
}

if (props.dot) {
  classNameValue.value = `${classNameValue.value} loader-dot`;
}

const props = defineProps({
  position: {
    type: String,
    default: null,
  },

  dot: {
    type: Boolean,
    default: false,
  },
});
</script>
