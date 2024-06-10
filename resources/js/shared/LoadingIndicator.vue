<template>
  <div v-if="dot" :class="classNameValue"><div :class="loaderSize">..........</div></div>
  <div v-if="!dot" :class="classNameValue">
    <div :class="loaderSize"><i class="fas fa-spinner fa-spin"></i></div>
    <p v-show="showBelowText" :class="loaderPSizeClassName">Please wait...</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

let classNameValue = ref(""),
  loaderSize = ref("");

const props = defineProps({
  position: {
    type: String,
    default: null,
  },

  dot: {
    type: Boolean,
    default: false,
  },

  loaderSize: {
    type: String,
    default: "large",
  },

  centerLoader: {
    type: Boolean,
    default: true,
  },

  loaderPSizeClassName: {
    type: String,
    default: "",
  },
  showBelowText: {
    type: Boolean,
    default: true,
  },
});

onMounted(() => {
  if (props.loaderSize == "large") {
    loaderSize.value = "fa-3x";
  }

  if (props.loaderSize == "med") {
    loaderSize.value = "fa-2x";
  }

  if (props.loaderSize == "small") {
    loaderSize.value = "fa-1x";
  }

  if (props.centerLoader) {
    classNameValue.value = "loader";
  }

  if (props.position !== null && props.position === "full-page") {
    classNameValue.value = `${classNameValue.value} full-page-loader`;
  }

  if (props.dot) {
    classNameValue.value = `${classNameValue.value} loader-dot`;
  }
});
</script>
