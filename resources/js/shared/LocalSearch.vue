<template>
  <div class="input-group local-search-wrapper">
    <span class="local-search-icon">
      <i class="fas fa-search"></i>
    </span>
    <input
      type="text"
      :class="{
        [inputClass]: true,
        'local-search-input form-control': true,
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
  arrType: {
    type: String,
    default: "obj",
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

  elementName: {
    type: String,
    default: "",
  },
});

const emit = defineEmits(["updateResultObj"]);

const clearFilterInput = () => {
  filterText.value = "";
};

const sortSideBarData = (newValue) => {
  let newArrObj = [];
  for (let index = 0; index < props.oldResultObj.length; index++) {
    if (
      props.oldResultObj[index].name.toLowerCase().indexOf(newValue.toLowerCase()) > -1
    ) {
      newArrObj.push(props.oldResultObj[index]);
    }
  }

  return newArrObj;
};

watch(filterText, (newValue) => {
  let newArrObj = [];

  if (newValue == "") {
    newArrObj = props.oldResultObj;
    //console.log(newArrObj);
  } else {
    if (props.elementName == "sidebar") {
      newArrObj = sortSideBarData(newValue);
    } else {
      newArrObj = returnFilteredText(
        newValue,
        props.oldResultObj,
        props.whatToCheck,
        props.arrType
      );
    }
  }

  emit("updateResultObj", { arrObj: newArrObj, newValue: newValue });
});
</script>
