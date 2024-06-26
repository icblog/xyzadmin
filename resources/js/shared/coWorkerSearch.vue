<template>
  <div class="coworker-search-wrapper">
    <div class="coworker-search-input-wrapper">
      <input
        ref="searchInput"
        v-model="searchedWord"
        type="text"
        :class="{ 'form-control pr-5': true }"
        :placeholder="placeholderText"
        maxlength="255"
        autocomplete="off"
        @keypress.enter.prevent
      />
      <span
        v-if="searchedWord.length > 0"
        class="clear-search-icon-times"
        @click="clearSearchInput"
      >
        <i class="fas fa-times"></i>
      </span>
    </div>
    <div class="co-worker-search-result" v-show="searchedWord != ''">
      <section v-show="searchData.isSearching">
        <LoadingIndicator loaderSize="small" />
      </section>
      <section
        v-show="
          searchData.isSearchComplete &&
          !searchData.isSearching &&
          searchData.coWorkerResData.length > 0
        "
      >
        <p className="text-center number-result-found-p">
          {{
            searchData.coWorkerResData.length > 1
              ? "(" + searchData.coWorkerResData.length + ") " + resultFoundTextplural
              : "(" + searchData.coWorkerResData.length + ") " + resultFoundTextSingular
          }}
          found
        </p>

        <div v-for="(coWorker, index) in searchData.coWorkerResData" :key="index">
          <p class="result-entry-p" @click="() => handleResultClicked(coWorker)">
            {{ returnPtext(coWorker) }}
          </p>
        </div>
      </section>

      <section
        class="blog-search-result"
        v-show="
          searchData.isSearchComplete &&
          !searchData.isSearching &&
          searchData.coWorkerResData.length <= 0 &&
          searchedWord != ''
        "
      >
        <div className="text-center pt-3">
          <p class="text-center">
            {{ noResultText }}
          </p>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, reactive, onMounted } from "vue";
import {
  focusOnFirstInput,
  returnSystemErrorMsg,
  returnCoWorkerFullName,
} from "../helper/util";
import LoadingIndicator from "./LoadingIndicator.vue";
import axios from "../api/axios";
import { debounce } from "lodash";

let searchedWord = ref(""),
  searchInput = ref(null);

const emit = defineEmits(["updateSelected"]);

const props = defineProps({
  focusOnSearchInput: {
    type: Boolean,
    default: false,
  },
  isSearchOn: {
    type: Boolean,
    default: false,
  },
  makeResultAlink: {
    type: Boolean,
    default: true,
  },
  resultFoundTextSingular: {
    type: String,
    default: "result",
  },
  resultFoundTextplural: {
    type: String,
    default: "results",
  },
  linkUrl: {
    type: String,
    default: "",
  },
  placeholderText: {
    type: String,
    default: "Search co-worker ....",
  },

  end_point: {
    type: String,
    default: "/find-coworker",
  },

  noResultText: {
    type: String,
    default: "Sorry no result found, please try again thank you.",
  },
  dataStringValue: {
    type: String,
    default: "name",
  },
  isGeneralData: {
    type: Boolean,
    default: false,
  },
});

const clearSearchInput = () => {
  searchedWord.value = "";
};

const handleResultClicked = (optionClciked) => {
  if (!props.makeResultAlink) {
    //emit click result to parent
    emit("updateSelected", optionClciked);
  }
};

const searchData = reactive({
  isSearching: false,
  isSearchComplete: false,
  customErr: "",
  coWorkerResData: [],
});

const returnPtext = (p_data) => {
  if (props.isGeneralData) {
    return p_data[props.dataStringValue];
  } else {
    return returnCoWorkerFullName(p_data.fname, p_data.lname);
  }
};

const handleSearchForm = async (searchedWordValue) => {
  if (searchedWordValue != "") {
    searchData.isSearching = true;

    if (searchData.isSearchComplete) {
      searchData.isSearchComplete = false;
    }

    try {
      const res = await axios.post(props.end_point, {
        searchedword: searchedWordValue,
      });

      if (res?.data?.error != "") {
        searchData.customErr = res.data.error;
      } else {
        searchData.coWorkerResData = res?.data?.coWorkerResData;
      }
    } catch (err) {
      searchData.customErr = returnSystemErrorMsg();
      //console.log(err);
    } finally {
      searchData.isSearching = false;
      searchData.isSearchComplete = true;
    }
  } //End if search text not empty
};

onMounted(() => {
  if (props.focusOnSearchInput) {
    focusOnFirstInput(searchInput);
  }
});

//Watch the search input value for changes.
watch(
  searchedWord,
  debounce((value) => {
    handleSearchForm(value);
  }, 400)
);
</script>
