<template>
  <div class="side-bar-details-inner-wrapper">
    <div class="side-bar-details" v-for="(postEntry, index) in postResult" :key="index">
      <div
        v-if="requestSlug != postEntry.slug && index < 3"
        class="side-bar-card card no-border mt-3 mb-3"
      >
        <div class="row no-gutters">
          <div class="col-sm-5">
            <AppLink :linkUrl="`/blog/${postEntry.slug}`">
              <img
                class="img-fluid"
                :src="postEntry.imgUrls === null ? defaultImgLink : postEntry.imgUrls"
                alt=""
              />
            </AppLink>
          </div>

          <div className="col-sm-7 p-2">
            <p class="post-entry-title">
              <AppLink :linkUrl="`/blog/${postEntry.slug}`">
                {{ limitStringFunc(60, postEntry.title) }}
              </AppLink>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AppLink from "../../shared/AppLink.vue";

export default {
  components: { AppLink },

  props: {
    postResult: Object,

    requestSlug: {
      type: String,
      default: "",
    },

    defaultImgLink: {
      type: String,
      default: "",
    },
    limitStringFunc: {
      type: Function,
      default: null,
    },
  },
};
</script>
