<template>
  <div class="input-group sidebar-search-category-input-wrapper mb-3 mt-4">
    <span class="sidebar-search-category-icon-search">
      <i class="fas fa-search"></i>
    </span>
    <input
      type="text"
      class="form-control sidebar-search-category-input"
      placeholder="Search category"
      v-model="filterText"
    />
    <span
      v-if="filterText.length > 0"
      class="sidebar-search-category-icon-times"
      @click="clearCategoryFilterInput"
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
});

const emit = defineEmits();

const clearCategoryFilterInput = () => {
  filterText.value = "";
};

watch(filterText, (newValue) => {
  let newArrObj = [];
  if (newValue == "") {
    newArrObj = props.oldResultObj;
  } else {
    newArrObj = returnFilteredText(newValue, props.oldResultObj, props.whatToCheck);
  }

  emit("updateCategoriesResult", { arrObj: newArrObj, newValue: newValue });
});
</script>
