<template>
  <section class="mb-5" v-if="props.categoriesResult.length > 0">
    <span>
      {{ props.categoryIds.length > 0 ? "Your selection: " : "Select: " }}
    </span>
    <span
      v-if="props.categoryIds.length > 0"
      v-for="(selectedCat, i) in props.categoryIds"
      :key="i"
      class="bolded pr-2"
    >
      {{ selectedCat.name }}
    </span>
    <div class="text-danger small" v-if="props.selectError">
      {{ props.selectError }}
    </div>
    <div class="input-group sidebar-search-category-input-wrapper">
      <span class="sidebar-search-category-icon-search">
        <i class="fas fa-search"></i>
      </span>
      <input
        type="text"
        class="form-control sidebar-search-category-input"
        placeholder="Search category"
        v-model="selectData.filterText"
      />
      <span
        v-if="selectData.filterText.length > 0"
        class="sidebar-search-category-icon-times"
        @click="clearFilterInput"
      >
        <i class="fas fa-times"></i>
      </span>
    </div>
    <div id="categories" class="custom-select-container form-control">
      <span
        v-for="(category, index) in returnFilteredText(
          selectData.filterText,
          props.categoriesResult,
          'name'
        )"
        :key="index"
        :value="category.id"
        :class="{
          'span-wrapper': true,
          'value-selected': checkIfAvalueIncludesInArrOrObj(
            category.id,
            props.categoryIds,
            'id'
          ),
        }"
        @click="() => onSelect(category.id, category.name)"
      >
        {{ category.name }}
      </span>
    </div>
  </section>
</template>

<script setup>
import { reactive } from "vue";
import {
  returnFilteredText,
  removeItemFromArrOrObjByValue,
  checkIfAvalueIncludesInArrOrObj,
} from "../../helper/util";
//import Multiselect from "vue-multiselect";
const emit = defineEmits();
const props = defineProps({
  categoriesResult: {
    type: Object,
    default: {},
  },

  selectError: {
    type: String,
    default: "",
  },
  categoryIds: {
    type: Array,
    default: [],
  },
});

const selectData = reactive({
  filterText: "",
});

const clearFilterInput = () => {
  selectData.filterText = "";
};

const onSelect = (selectedId, selectedName) => {
  let tempObj = [];
  if (checkIfAvalueIncludesInArrOrObj(selectedId, props.categoryIds, "id")) {
    tempObj = removeItemFromArrOrObjByValue(Number(selectedId), props.categoryIds, "id");
  } else {
    tempObj = props.categoryIds;
    tempObj.push({
      id: selectedId,
      name: selectedName,
    });
  }
  emit("addorremove", tempObj);
};
</script>
