<template>
  <div v-show="allowSearch">
    <LocalSearch
      :oldResultObj="resultObj"
      whatToCheck="name"
      :inputPlaceHolderValue="placeHolderText"
      inputClass="custom-search-input"
      @updateResultObj="updateResultObj"
    />
  </div>
  <div :class="'option-element-wrapper ' + customWrapperClass">
    <ul>
      <li
        v-if="optionElementData.filteredResultObject.length > 0"
        v-for="(option, optionIndex) in optionElementData.filteredResultObject"
        :key="optionIndex"
        :class="option.name == optionSelected ? 'option-selected' : ''"
        @click="() => handleSelectedOptionClicked(option.name)"
      >
        {{ option.name }}
      </li>
    </ul>
  </div>
</template>
<script setup>
import { reactive } from "vue";
import LocalSearch from "./LocalSearch.vue";
const emit = defineEmits(["updateSelectedOptionInput"]);
const props = defineProps({
  resultObj: {
    type: Object,
    default: {},
  },
  optionSelected: {
    type: String,
    default: "",
  },
  placeHolderText: {
    type: String,
    default: "Search ....",
  },
  allowSearch: {
    type: Boolean,
    default: true,
  },
  customWrapperClass: {
    type: String,
    default: "",
  },
});

const optionElementData = reactive({
  filteredResultObject: props.resultObj,
});

const updateResultObj = (resultObj) => {
  optionElementData.filteredResultObject = resultObj.arrObj;
};
const handleSelectedOptionClicked = (optionClciked) => {
  if (optionClciked != props.optionSelected) {
    emit("updateSelectedOptionInput", optionClciked);
  }
};
</script>
