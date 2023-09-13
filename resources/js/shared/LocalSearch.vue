<template>
  <div class="input-group local-search-wrapper">
    <span class="local-search-icon">
      <i class="fas fa-search"></i>
    </span>
    <input
      type="text"
      :class="{
        [inputClass]: true,
        'form-control': true,
        'local-search-input': true,
      }"
      :placeholder="inputPlaceHolderValue"
      v-model="filterText"
    />
    <span
      v-if="filterText.length > 0"
      class="local-search-icon-times"
      @click="clearFilterInput"
    >
      <i class="fas fa-times"></i>
    </span>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { returnFilteredText } from "../helper/util";
let filterText = ref("");

const props = defineProps({
  oldResultObj: {
    type: Object,
    default: {},
  },

  whatToCheck: {
    type: String,
    default: "name",
  },

  inputPlaceHolderValue: {
    type: String,
    default: "Search ....",
  },
  inputClass: {
    type: String,
    default: "",
  },
});

const emit = defineEmits(["updateResultObj"]);

const clearFilterInput = () => {
  filterText.value = "";
};

watch(filterText, (newValue) => {
  let newArrObj = [];
  if (newValue == "") {
    newArrObj = props.oldResultObj;
    //console.log(newArrObj);
  } else {
    newArrObj = returnFilteredText(newValue, props.oldResultObj, props.whatToCheck);
  }

  emit("updateResultObj", { arrObj: newArrObj, newValue: newValue });
});
</script>
