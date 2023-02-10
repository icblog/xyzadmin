<template>
  <div class="blog-search-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-10 mx-auto">
          <input
            ref="blogSearchInput"
            v-model="searchedWord"
            type="text"
            class="form-control"
            placeholder="Search for post..."
          />
          <div class="blog-search-result" v-show="searchedWord != ''">
            <section v-show="searchData.isSearching">
              <LoadingIndicator />
            </section>
            <section
              v-show="
                searchData.isSearchComplete &&
                !searchData.isSearching &&
                searchData.postData.length > 0
              "
            >
              <p className="text-center number-result-found-p">
                {{
                  searchData.postData.length > 1
                    ? "(" + searchData.postData.length + ") results "
                    : "(" + searchData.postData.length + ") result "
                }}
                found
              </p>

              <div v-for="(postEntry, index) in searchData.postData" :key="index">
                <p class="post-entry-title">
                  <AppLink :linkUrl="`/blog/${postEntry.slug}`">
                    {{ limitString(60, postEntry.title) }}
                  </AppLink>
                </p>
              </div>
            </section>

            <section
              class="blog-search-result"
              v-show="
                searchData.isSearchComplete &&
                !searchData.isSearching &&
                searchData.postData.length <= 0 &&
                searchedWord != ''
              "
            >
              <div className="text-center pt-3">
                <HandleMsg
                  infotype="info"
                  :msg="`Sorry no result found for (${searchedWord}) search, please try again thank you.`"
                />
              </div>
            </section>
          </div>
        </div>
        <!-- END COL-MD-12 -->
      </div>
      <!-- END ROW -->
    </div>
  </div>
</template>

<script setup>
import { ref, watch, watchEffect, reactive } from "vue";
import { focusOnFirstInput, returnSystemErrorMsg, limitString } from "../../helper/util";
import LoadingIndicator from "../../shared/LoadingIndicator.vue";
import AppLink from "../../shared/AppLink.vue";
import HandleMsg from "../../shared/HandleMsg.vue";
import axios from "../../api/axios";
import { debounce } from "lodash";

let blogSearchInput = ref(null),
  searchedWord = ref("");

const props = defineProps({
  isSearchOn: {
    type: Boolean,
    default: false,
  },
});

const searchData = reactive({
  isSearching: false,
  isSearchComplete: false,
  customErr: "",
  defaultImgLink: "",
  postData: {},
});

const handleSearchForm = async (searchedWordValue) => {
  if (searchedWordValue != "") {
    searchData.isSearching = true;

    if (searchData.isSearchComplete) {
      searchData.isSearchComplete = false;
    }

    try {
      const res = await axios.post("/blog/search-post", {
        searchedword: searchedWordValue,
      });

      if (res?.data?.error != "") {
        searchData.customErr = res.data.error;
      } else {
        searchData.postData = res.data.postData;
        searchData.defaultImgLink = res.data.defaultImgLink;
      }
    } catch (err) {
      searchData.customErr = returnSystemErrorMsg();
      console.log(err);
    } finally {
      searchData.isSearching = false;
      searchData.isSearchComplete = true;
    }
  } //End if search text is greater than 2
};

watchEffect(() => {
  //Keep an eye on the search bar to see if it visible
  if (props.isSearchOn) {
    //Wait afew seconds for the input to become ready
    //before focusing on it.
    setTimeout(() => {
      focusOnFirstInput(blogSearchInput);
    }, 50);
  } else {
    searchedWord.value = "";
    searchData.postData = [];
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
