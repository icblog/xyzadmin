<template>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-2">
    <div class="side-bar-details-wrapper">
      <section class="mb-5" v-if="categoriesResult.length > 0">
        <h5>Categories</h5>
        <!-- Filter category -->
        <LocalSearch
          :oldResultObj="categoriesResult"
          whatToCheck="name"
          @updateCategoriesResult="returnFilteredCategoriesResult"
        />

        <div class="sidebar-category-wrapper">
          <section v-if="categoriesResultData.length > 0">
            <div v-for="(category, index) in categoriesResultData" :key="index">
              <div class="sidebar-category-link-wrapper">
                <span
                  v-if="
                    replaceChar(category.name.toLowerCase(), ' ', '-') === requestSlug
                  "
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
          </section>
          <section v-else>
            <span class="sidebar-category-span"> No category found </span>
          </section>
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
        <div class="pt-1 pb-5">
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
        <div class="pt-1 pb-4">
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
import LocalSearch from "../../shared/LocalSearch.vue";
import { replaceChar } from "../../helper/util";

export default {
  components: { HandleMsg, AppLink, SideBarPostCard, LocalSearch },

  data() {
    return {
      filterText: "",
      categoriesResultData: this.categoriesResult,
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
    returnFilteredCategoriesResult({ arrObj }) {
      this.categoriesResultData = arrObj;
    },
  },
};
</script>
