<template>
  <div :class="classValue + ' ' + customClass" aria-live="assertive">
    <span v-show="showHeading">
      <strong>{{ msgHeading }}</strong
      ><br />
    </span>
    <span v-html="props.msg"></span>
    <!-- {{ props.msg }} -->
  </div>
</template>

<script setup>
import { ref } from "vue";

let classValue = ref("no-border-radius alert"),
  msgHeading = ref("");
if (props.infotype == "success") {
  classValue.value = `${classValue.value} alert-success text-success`;
  msgHeading.value = props.customHeading == "" ? "Success!" : props.customHeading;
}

if (props.infotype == "error") {
  classValue.value = `${classValue.value} alert-danger text-danger`;
  msgHeading.value = props.customHeading == "" ? "Error!" : props.customHeading;
}

if (props.infotype == "info") {
  classValue.value = `${classValue.value} alert-secondary`;
  msgHeading.value = props.customHeading == "" ? "Info!" : props.customHeading;
}

const props = defineProps({
  infotype: {
    type: String,
    requred: true,
  },
  msg: {
    type: String,
    requred: true,
  },
  customClass: {
    type: String,
    default: "",
  },
  showHeading: {
    type: Boolean,
    default: true,
  },
  customHeading: {
    type: String,
    default: "",
  },
});
</script>
