<template>
  <a v-show="linkType === 'ext'" :class="className" :href="linkUrl" target="_blank">
    <slot />
  </a>
  <Link v-show="linkType === 'int'" :class="className" :href="linkUrl">
    <slot />
  </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
const props = defineProps({
  linkType: {
    type: String,
    default: "int",
  },
  className: {
    type: String,
    default: "",
  },

  linkUrl: {
    type: String,
    default: "",
    requred: true,
  },
});
</script>
