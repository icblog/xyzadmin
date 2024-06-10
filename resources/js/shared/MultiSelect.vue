<template>
  <section class="option-select-input-outer-wrapper">
    <div v-show="!labelPrepend">
      <label class="form-label">{{ labelName }} </label>
    </div>
    <div class="text-danger small d-block" v-show="inputErrMsg != ''">
      {{ inputErrMsg }}
    </div>
    <div>
      <div v-show="labelPrepend" class="input-group-prepend mr-1">
        <label class="form-label">{{ labelName }} </label>
      </div>

      <div
        v-show="defaultOptionSelected.length > 0"
        :class="{
          'option-toggle-btn-wrapper': true,
        }"
      >
        <span v-show="defaultOptionSelected.length > 0">
          <span
            v-for="(selected_option, index) in defaultOptionSelected"
            :key="index"
            class="pr-2"
          >
            {{ selected_option.name }}
            <span
              @click="() => removeSelected(selected_option.id)"
              class="pl-1 pr-1 badge badge-dark remove-selected"
              >X</span
            >
          </span>
        </span>
      </div>

      <AppButton
        btnType="button"
        customClass="option-toggle-btn multi-toggle-btn"
        :btnFunc="toggleOptionDiv"
      >
        <span class="pr-2">{{
          optionElementData.isOptionDivOpen ? "Close" : "Select..."
        }}</span>
        <i
          :class="
            optionElementData.isOptionDivOpen ? 'fas fa-arrow-up' : 'fas fa-arrow-down'
          "
        ></i>
      </AppButton>
    </div>
    <div
      v-show="optionElementData.isOptionDivOpen"
      :class="'option-select-input-wrapper ' + customWrapperClass"
    >
      <div v-show="allowSearch">
        <LocalSearch
          :arrType="arrType"
          :oldResultObj="resultObj"
          whatToCheck="name"
          :inputPlaceHolderValue="searchPlaceHolderText"
          inputClass="custom-search-input"
          @updateResultObj="updateResultObj"
        />
      </div>

      <ul v-if="arrType == 'obj'">
        <li
          v-if="optionElementData.filteredResultObject.length > 0"
          v-for="(option, optionIndex) in optionElementData.filteredResultObject"
          :key="optionIndex"
          :class="
            checkIfAvalueIncludesInArrOrObj(option.id, defaultOptionSelected, 'id')
              ? 'option-selected'
              : ''
          "
          @click="() => handleSelectedOptionClicked(option)"
        >
          {{ option.name }}
        </li>
      </ul>

      <ul v-else>
        <li
          v-if="optionElementData.filteredResultObject.length > 0"
          v-for="(option, optionIndex) in optionElementData.filteredResultObject"
          :key="optionIndex"
          :class="
            checkIfAvalueIncludesInArrOrObj(option.id, defaultOptionSelected, 'id')
              ? 'option-selected'
              : ''
          "
          @click="() => handleSelectedOptionClicked(option)"
        >
          {{ returnPartOfstr(option) }}
        </li>
      </ul>
    </div>
  </section>
</template>
<script setup>
import { reactive } from "vue";
import LocalSearch from "./LocalSearch";
import AppButton from "./AppButton";
import {
  returnAllStrAfterFirstChar,
  checkIfAvalueIncludesInArrOrObj,
  removeItemFromArrOrObjByValue,
} from "../helper/util";

const emit = defineEmits(["updateSelectedOptionInput"]);

//Pass v-model="reactive data varible from parent goes here"  as prop If using input as text

const props = defineProps({
  arrType: {
    type: String,
    default: "obj",
  },
  resultObj: {
    type: Object,
    default: {},
  },
  searchPlaceHolderText: {
    type: String,
    default: "Search ....",
  },

  selectPlaceHolderText: {
    type: String,
    default: "Select...",
  },

  customWrapperClass: {
    type: String,
    default: "",
  },
  whatToget: {
    type: String,
    default: "name",
  },
  defaultOptionSelected: {
    type: Array,
    default: [],
  },

  labelName: {
    type: String,
    default: "",
  },
  inputErrMsg: {
    type: String,
    default: "",
  },
  labelPrepend: {
    type: Boolean,
    default: false,
  },

  allowSearch: {
    type: Boolean,
    default: true,
  },
  trimDetail: {
    type: Boolean,
    default: false,
  },
  inputFocusFunc: {
    type: Function,
    default: null,
  },
});

const optionElementData = reactive({
  filteredResultObject: props.resultObj,
  isOptionDivOpen: false,
});
const toggleOptionDiv = () => {
  optionElementData.isOptionDivOpen = !optionElementData.isOptionDivOpen;
};

const updateResultObj = (resultObj) => {
  optionElementData.filteredResultObject = resultObj.arrObj;
};

const handleSelectedOptionClickedObject = (optionClicked) => {
  //send id or name to parent depending on whatToget value
  let optionValue = "";
  if (props.whatToget == "name") {
    optionValue = optionClicked?.name;
  } else if (props.whatToget == "id") {
    optionValue = {
      name: optionClicked?.name,
      id: optionClicked?.id,
    };
  }
  emit("updateSelectedOptionInput", {
    value: optionValue,
    action: "push",
  });
};

const handleSelectedOptionClickedArray = (optionClicked) => {
  emit("updateSelectedOptionInput", {
    value: optionClicked,
    action: "push",
  });
};

const handleSelectedOptionClicked = (optionClicked) => {
  if (
    !checkIfAvalueIncludesInArrOrObj(optionClicked.id, props.defaultOptionSelected, "id")
  ) {
    if (props.arrType == "obj") {
      handleSelectedOptionClickedObject(optionClicked);
    } else if (props.arrType == "arr") {
      handleSelectedOptionClickedArray(optionClicked);
    }
  }
};

const returnPartOfstr = (str) => {
  if (props.trimDetail) {
    return returnAllStrAfterFirstChar(str);
  } else {
    return str;
  }
};

const removeSelected = (selected_id) => {
  const tempObj = removeItemFromArrOrObjByValue(
    selected_id,
    props.defaultOptionSelected,
    "id"
  );

  emit("updateSelectedOptionInput", {
    value: tempObj,
    action: "replace",
  });
};
</script>
