<template>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-2">
    <div class="side-bar-details-wrapper">
      <section class="mb-5" v-if="categoriesResult.length > 0">
        <h5>Categories</h5>
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
        <div class="sidebar-category-wrapper">
          <div
            v-for="(category, index) in returnFilteredText(
              filterText,
              categoriesResult,
              'name'
            )"
            :key="index"
          >
            <div class="sidebar-category-link-wrapper">
              <span
                v-if="replaceChar(category.name.toLowerCase(), ' ', '-') === requestSlug"
              >
                <span class="sidebar-category-span">
                  {{ category.name }} ({{ category.categoryPostTotal }})
                </span>
              </span>

              <span v-else>
                <AppLink
                  :linkUrl="`/blog/category/${replaceChar(
                    category.name.toLowerCase(),
                    ' ',
                    '-'
                  )}`"
                  ><span class="sidebar-category-span"
                    >{{ category.name }} ({{ category.categoryPostTotal }})</span
                  ></AppLink
                >
              </span>
            </div>
          </div>
        </div>
        <hr />
      </section>
      <section v-if="requestSlug != 'popular' && popularPostResult.length > 1">
        <h5>Popular post</h5>
        <SideBarPostCard
          :postResult="popularPostResult"
          :requestSlug="requestSlug"
          :defaultImgLink="defaultImgLink"
          :limitStringFunc="limitStringFunc"
        />
        <div class="text-center pt-1 pb-4">
          <AppLink linkUrl="/blog/post/popular"> View all popular </AppLink>
        </div>
      </section>

      <section v-if="requestSlug != 'latest' && latestPostResult.length > 1">
        <h5>Latest post</h5>
        <SideBarPostCard
          :postResult="latestPostResult"
          :requestSlug="requestSlug"
          :defaultImgLink="defaultImgLink"
          :limitStringFunc="limitStringFunc"
        />
        <div class="text-center pt-1 pb-4">
          <AppLink linkUrl="/blog/post/latest"> View all latest </AppLink>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import AppLink from "../../shared/AppLink.vue";
import HandleMsg from "../../shared/HandleMsg.vue";
import SideBarPostCard from "./SideBarPostCard.vue";
import { replaceChar, returnFilteredText } from "../../helper/util";

export default {
  components: { HandleMsg, AppLink, SideBarPostCard },

  data() {
    return {
      filterText: "",
    };
  },

  props: {
    requestSlug: {
      type: String,
      default: "",
    },

    defaultImgLink: {
      type: String,
      default: "",
    },

    categoriesResult: Object,
    latestPostResult: Object,
    popularPostResult: Object,
    limitStringFunc: {
      type: Function,
      default: null,
    },
  },
  methods: {
    replaceChar,
    returnFilteredText,
    clearCategoryFilterInput() {
      this.filterText = "";
    },
  },
};
</script>
