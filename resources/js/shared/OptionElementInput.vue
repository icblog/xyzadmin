<template>
  <section class="option-select-input-outer-wrapper">
    <div v-show="labelName != '' && !labelPrepend">
      <label class="form-label">{{ labelName }}</label>
    </div>
    <div class="text-danger small d-block" v-show="inputErrMsg != ''">
      {{ inputErrMsg }}
    </div>
    <div class="input-group">
      <div v-show="labelName != '' && labelPrepend" class="input-group-prepend mr-1">
        <label class="form-label">{{ labelName }} </label>
      </div>

      <input
        v-model="optionElementData.optionSelected"
        @input="updateValue"
        :type="disabledInput ? 'button' : 'text'"
        :placeholder="optionElementData.placeHolder"
        :class="{
          'form-control': true,
          'option-selected-input': disabledInput ? true : false,
        }"
        @click="toggleOptionDiv"
        @focus="inputFocusFunc"
      />
      <div class="input-group-append">
        <AppButton
          btnType="button"
          customClass="option-toggle-btn"
          :btnFunc="toggleOptionDiv"
        >
          <i
            :class="
              optionElementData.isOptionDivOpen ? 'fas fa-arrow-up' : 'fas fa-arrow-down'
            "
          ></i>
        </AppButton>
      </div>
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
      <!-- if object -->
      <ul v-if="arrType == 'obj'">
        <li
          v-if="optionElementData.filteredResultObject.length > 0"
          v-for="(option, optionIndex) in optionElementData.filteredResultObject"
          :key="optionIndex"
          :class="{
            'option-selected-hidden': itemToHide == returnPartOfstr(option.name),
            'option-selected':
              returnPartOfstr(option.name) == optionElementData.optionSelected,
          }"
          @click="() => handleSelectedOptionClicked(option)"
        >
          {{ returnPartOfstr(option.name) }}
        </li>
      </ul>
      <!-- if array -->
      <ul v-else>
        <li
          v-if="optionElementData.filteredResultObject.length > 0"
          v-for="(option, optionIndex) in optionElementData.filteredResultObject"
          :key="optionIndex"
          :class="{
            'option-selected-hidden': itemToHide == returnPartOfstr(option),
            'option-selected':
              returnPartOfstr(option) == optionElementData.optionSelected,
          }"
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
import { returnAllStrAfterFirstChar } from "../helper/util";
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

  customWrapperClass: {
    type: String,
    default: "",
  },
  whatToget: {
    type: String,
    default: "name",
  },
  defaultOptionSelected: {
    type: String,
    default: "",
  },
  itemToHide: {
    type: String,
    default: "",
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
  disabledInput: {
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
  allowSelection: {
    type: Boolean,
    default: true,
  },
  inputFocusFunc: {
    type: Function,
    default: null,
  },
});

const optionElementData = reactive({
  filteredResultObject: props.resultObj,
  isOptionDivOpen: false,
  optionSelected: props.defaultOptionSelected,
  placeHolder: props.disabledInput ? "Select...." : "Type or select " + props.labelName,
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
  if (optionClicked?.name != optionElementData.optionSelected) {
    //close option div wrapper
    optionElementData.isOptionDivOpen = false;
    //Change input value
    optionElementData.optionSelected = optionClicked?.name;
    emit("updateSelectedOptionInput", optionValue);
  }
};

const handleSelectedOptionClickedArray = (optionClicked) => {
  if (returnPartOfstr(optionClicked) != optionElementData.optionSelected) {
    //close option div wrapper
    optionElementData.isOptionDivOpen = false;
    //Change input value
    optionElementData.optionSelected = returnPartOfstr(optionClicked);
    emit("updateSelectedOptionInput", optionClicked);
  }
};

const handleSelectedOptionClicked = (optionClicked) => {
  if (props.allowSelection) {
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

const updateValue = (event) => {
  setTimeout(() => {
    emit("updateSelectedOptionInput", event.target.value);
  }, 600);
};
</script>
