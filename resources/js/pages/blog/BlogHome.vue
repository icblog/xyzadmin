<template>
  <Layout pageTitle="blog-home">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="page-intro-wrapper pb-3">
            <h1>{{ pageIntro }}</h1>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 mt-2 mb-3">
          <div class="post-wrapper box-shadow">
            <!-- <section v-if="processing"><LoadingIndicator /></section> -->

            <section>
              <HandleMsg v-if="errors.fail" infotype="error" :msg="errors.fail" />
              <div class="row pt-1 display-flex">
                <div v-if="mainPostResult.length === 0" class="col-md-12 pt-5 mt-5">
                  <HandleMsg
                    infotype="info"
                    :msg="`Sorry there no <strong>${urlSlug}</strong> post, please try again later thank you`"
                  />
                </div>

                <div
                  v-else
                  v-for="(postEntry, index) in mainPostResult"
                  class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pb-3 pt-3"
                  :key="index"
                >
                  <div class="post-entry-wrapper">
                    <AppLink :linkUrl="`/blog/${postEntry.slug}`">
                      <img
                        class="card-img no-border-radius"
                        :src="
                          postEntry.imgUrls === null ? defaultImgLink : postEntry.imgUrls
                        "
                        alt=""
                      />
                    </AppLink>
                    <div class="post-entry-detail-wrapper">
                      <p class="post-entry-title">
                        <AppLink :linkUrl="`/blog/${postEntry.slug}`">
                          {{ limitString(40, postEntry.title) }}
                        </AppLink>
                      </p>

                      <p class="post-entry-detail-p">
                        <strong>By:</strong> {{ postEntry.createdby_name }}<br />
                        <strong>Date: </strong
                        >{{ returnFormattedDate(postEntry.created_at) }}<br />
                        <strong>Category: </strong>

                        <span v-if="urlAction == 'category'">
                          <span
                            v-for="(categoryEntry, i) in returnPostEntryCatLinkArray(
                              postEntry
                            ).catNameArray"
                            class="post-entry-category-link-span"
                            :key="i"
                          >
                            {{ categoryEntry }}
                          </span>
                        </span>

                        <span
                          v-else
                          v-for="(categoryEntry, i) in returnPostEntryCatLinkArray(
                            postEntry
                          ).catNameArray"
                          :key="i"
                          class="post-entry-category-link-span"
                        >
                          <AppLink
                            :linkUrl="`/blog/category/${
                              returnPostEntryCatLinkArray(postEntry).catSlugArray[i]
                            }`"
                            >{{ categoryEntry }}</AppLink
                          > </span
                        ><br />
                        <strong>Views:</strong> {{ postEntry.views }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <span ref="loadMoreIntersect" />
              <div v-if="isPaginating" class="text-center pt-4 pb-4">
                <LoadingIndicator />
              </div>
            </section>
          </div>
        </div>
        <!-- SideBar -->
        <BlogSideBar
          :requestSlug="urlSlug"
          :categoriesResult="categoriesResult"
          :latestPostResult="latestPostResult.data"
          :popularPostResult="popularPostResult.data"
          :limitStringFunc="limitString"
          :defaultImgLink="defaultImgLink"
        />
      </div>
    </div>
  </Layout>
</template>

<script>
import { router } from "@inertiajs/vue3";
import AppLink from "../../shared/AppLink.vue";
import Layout from "../../shared/Layout";
import HandleMsg from "../../shared/HandleMsg.vue";
import LoadingIndicator from "../../shared/LoadingIndicator.vue";
import BlogSideBar from "./BlogSideBar.vue";
import { limitString, returnFormattedDate } from "../../helper/util";
export default {
  components: { Layout, HandleMsg, LoadingIndicator, AppLink, BlogSideBar },

  props: {
    errors: {
      type: Object,
      default: {},
    },
    pageIntro: {
      type: String,
      default: "",
    },
    latestPostResult: {
      type: Object,
      default: {},
    },
    popularPostResult: {
      type: Object,
      default: {},
    },
    categoriesResult: {
      type: Array,
      default: [],
    },
    mainResult: {
      type: Object,
      default: {},
    },
    urlSlug: {
      type: String,
      default: "",
    },
    urlAction: {
      type: String,
      default: "",
    },
    defaultImgLink: {
      type: String,
      default: "",
    },
  },

  data() {
    return {
      isPaginating: false,
      mainPostResult: this.mainResult.data,
      initialUrl: this.$page.url,
    };
  },
  methods: {
    limitString,
    returnFormattedDate,
    loadMorePosts() {
      if (this.mainResult.next_page_url === null) {
        return;
      }

      router.get(
        this.mainResult.next_page_url,
        {},
        {
          preserveState: true,
          preserveScroll: true,
          only: ["mainResult"],
          onStart: () => {
            this.isPaginating = true;
          },
          onFinish: () => {
            this.isPaginating = false;
          },
          onSuccess: () => {
            this.mainPostResult = [...this.mainPostResult, ...this.mainResult.data];
            window.history.replaceState({}, this.$page.title, this.initialUrl);
          },
        }
      );
    },
    returnPostEntryCatLinkArray(postEntry) {
      let catNameArray = postEntry.catNames.split(","),
        catSlugArray = postEntry.catSlugs.split(",");
      return {
        catNameArray: catNameArray,
        catSlugArray: catSlugArray,
      };
    },
  },

  mounted() {
    // console.log(this.mainPostResult);
    const observer = new IntersectionObserver((entries) =>
      entries.forEach((entry) => entry.isIntersecting && this.loadMorePosts(), {
        rootMargin: "-150px 0px 0px 0px",
      })
    );

    observer.observe(this.$refs.loadMoreIntersect);
  },
};
</script>
