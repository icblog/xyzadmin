<template>
  <div :class="classValue" aria-live="assertive">
    <strong>{{ msgHeading }}</strong
    ><br />
    <span v-html="props.msg"></span>
    <!-- {{ props.msg }} -->
  </div>
</template>

<script setup>
import { ref } from "vue";

let classValue = ref("no-border-radius alert"),
  msgHeading = ref("");
if (props.infotype == "success") {
  classValue.value = `${classValue.value} alert-success`;
  msgHeading.value = "Success!";
}

if (props.infotype == "error") {
  classValue.value = `${classValue.value} alert-danger`;
  msgHeading.value = "Error!";
}

if (props.infotype == "info") {
  classValue.value = `${classValue.value} alert-secondary`;
  msgHeading.value = "Info!";
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
});
</script>
