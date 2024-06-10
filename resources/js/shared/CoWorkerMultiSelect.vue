<template>
  <section class="option-select-input-outer-wrapper">
    <div v-show="!labelPrepend">
      <label class="form-label">{{ labelName }} </label>
    </div>
    <div
      v-show="defaultOptionSelected.length > 0"
      :class="{
        'option-toggle-btn-wrapper': true,
      }"
    >
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
    </div>
    <CoWorkerSearch
      :makeResultAlink="false"
      resultFoundTextSingular="person"
      resultFoundTextplural="people"
      noResultText="Sorry no one found, try again thank you."
      @updateSelected="handleSelectedOptionClicked"
    />
  </section>
</template>
<script setup>
import CoWorkerSearch from "./CoWorkerSearch";
import {
  returnAllStrAfterFirstChar,
  checkIfAvalueIncludesInArrOrObj,
  removeItemFromArrOrObjByValue,
  returnCoWorkerFullName,
} from "../helper/util";

const emit = defineEmits(["updateSelectedOptionInput"]);

//Pass v-model="reactive data varible from parent goes here"  as prop If using input as text

const props = defineProps({
  arrType: {
    type: String,
    default: "obj",
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

  trimDetail: {
    type: Boolean,
    default: false,
  },
  inputFocusFunc: {
    type: Function,
    default: null,
  },
  labelPrepend: {
    type: Boolean,
    default: false,
  },
  labelName: {
    type: String,
    default: "",
  },
});

const handleSelectedOptionClickedObject = (optionClicked) => {
  //send id or name to parent depending on whatToget value
  let optionValue = "";
  if (props.whatToget == "name") {
    optionValue = returnCoWorkerFullName(optionClicked?.fname, optionClicked?.lname);
  } else if (props.whatToget == "id") {
    optionValue = {
      name: returnCoWorkerFullName(optionClicked?.fname, optionClicked?.lname),
      id: optionClicked?.id,
    };
  }
  emit("updateSelectedOptionInput", {
    value: optionValue,
    action: "push",
  });
};

const handleSelectedOptionClicked = (optionClicked) => {
  if (
    !checkIfAvalueIncludesInArrOrObj(optionClicked.id, props.defaultOptionSelected, "id")
  ) {
    handleSelectedOptionClickedObject(optionClicked);
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
