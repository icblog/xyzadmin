<template>
  <Layout pageTitle="blog-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="page-intro-wrapper">
            <h1>{{ singlePostResult?.title }}</h1>
            <p class="single-post-author-p">
              By: {{ singlePostResult?.createdby_name }} in
              <span
                v-if="singlePostResult != null"
                v-for="(categoryName, i) in singlePostResult.catNames"
                :key="i"
                class="post-entry-category-link-span pr-1"
              >
                <AppLink :linkUrl="`/blog/category/${singlePostResult.catSlugs[i]}`">{{
                  categoryName
                }}</AppLink>
              </span>
              on {{ singlePostResult?.created_at }}
            </p>
          </div>
        </div>
      </div>
      <div v-if="errors.fail" class="row">
        <div class="col-md-12">
          <HandleMsg infotype="error" :msg="errors.fail" />
        </div>
      </div>
      <div v-else class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 mt-2 mb-3">
          <div class="post-wrapper pt-2">
            <Markdown :source="singlePostResult?.body" />
          </div>

          <div class="col-md-12 no-padding next-prev-link-wrapper">
            <section>
              <div class="row mt-3">
                <!-- Previous post button -->
                <div class="col">
                  <div
                    v-if="previousPostResult != null"
                    class="next-prev-link-inner-wrapper text-left"
                  >
                    <AppLink :linkUrl="`/blog/${previousPostResult.slug}`">
                      <span
                        ><span class="small"
                          ><i class="fa fa-chevron-left"></i
                          ><i class="fa fa-chevron-left"></i
                        ></span>
                        Previous Post
                      </span>
                      <p>{{ limitString(40, previousPostResult.title) }}</p>
                    </AppLink>
                  </div>
                </div>
                <!-- Next post button -->
                <div class="col">
                  <div
                    v-if="nextPostResult != null"
                    class="next-prev-link-inner-wrapper text-left"
                  >
                    <AppLink :linkUrl="`/blog/${nextPostResult.slug}`">
                      <span
                        >Next Post
                        <span class="small"
                          ><i class="fa fa-chevron-right"></i
                          ><i class="fa fa-chevron-right"></i
                        ></span>
                      </span>
                      <p>{{ limitString(40, nextPostResult.title) }}</p>
                    </AppLink>
                  </div>
                </div>
              </div>
            </section>
            <!-- Blog comment -->
            <BlogComment
              :postId="singlePostResult?.id"
              :requestSlug="urlSlug"
              :postCommentResult="postCommentResult"
              :previousUserCommentResult="previousUserCommentResult"
            />

            <!-- Blog comment replies -->
            <BlogReplies :commentEntry="postCommentResult" />
          </div>
        </div>

        <!-- SideBar -->
        <BlogSideBar
          :requestSlug="urlSlug"
          :categoriesResult="categoriesResult"
          :latestPostResult="latestPostResult"
          :popularPostResult="popularPostResult"
          :limitStringFunc="limitString"
          :defaultImgLink="defaultImgLink"
        />
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Markdown from "vue3-markdown-it";
import Layout from "../../shared/Layout";
import AppLink from "../../shared/AppLink.vue";
import HandleMsg from "../../shared/HandleMsg.vue";
import BlogSideBar from "./BlogSideBar.vue";
import BlogComment from "./comments-replies/Comments.vue";
import BlogReplies from "./comments-replies/Replies.vue";
import { limitString } from "../../helper/util";

const props = defineProps({
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
  singlePostResult: {
    type: Object,
    default: null,
  },
  urlSlug: {
    type: String,
    default: "",
  },

  defaultImgLink: {
    type: String,
    default: "",
  },
  nextPostResult: {
    type: Object,
    default: null,
  },

  previousPostResult: {
    type: Object,
    default: null,
  },

  postCommentResult: {
    type: Object,
    default: [],
  },
  previousUserCommentResult: {
    type: Boolean,
    default: false,
  },
});
</script>
