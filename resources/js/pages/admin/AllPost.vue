<template>
  <Layout pageTitle="admin-all-post">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="page-intro-wrapper pb-3">
            <div class="row">
              <div class="col-md-7">
                <h1>{{ pageIntro }}</h1>
              </div>
              <div class="col-md-4 admin-page-intro-btn-wrapper">
                <AppLink
                  linkUrl="/admin/create-post"
                  className="btn btn-primary no-border-radius"
                >
                  Create new post <i class="fas fas fa-plus"></i>
                </AppLink>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 mt-2 mb-3">
          <div class="post-wrapper box-shadow">
            <!-- <section v-if="processing"><LoadingIndicator /></section> -->

            <section>
              <HandleMsg v-if="errors.fail" infotype="error" :msg="errors.fail" />
              <div class="row pt-1 display-flex">
                <div
                  v-if="mainPostResult.length === 0"
                  class="col-md-7 mx-auto pt-5 mt-5"
                >
                  <HandleMsg
                    infotype="info"
                    :msg="`Sorry there no post found, please try again later thank you`"
                  />
                </div>

                <div
                  v-else
                  v-for="(postEntry, index) in mainPostResult"
                  class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pb-3 pt-3"
                  :key="index"
                >
                  <div class="post-entry-wrapper action-btn-wrapper">
                    <span class="btn-wrapper">
                      <AppLink
                        :linkUrl="`/admin/${postEntry.id}`"
                        className="btn btn-primary no-border-radius"
                      >
                        <i class="fas fas fa-edit"></i>
                      </AppLink>
                      <AppButton
                        btnStyle="danger"
                        :btnFunc="
                          () =>
                            handleConfirmDeletePost(
                              postEntry.id,
                              postEntry.title,
                              postEntry.has_images,
                              postEntry.cloudinary_folder_name
                            )
                        "
                      >
                        <i class="fas fas fa-trash"></i>
                      </AppButton>
                    </span>
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
                        <strong>Category: </strong>
                        <span
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
                          >
                        </span>
                      </p>
                      <p class="post-entry-detail-p">
                        <strong>Date: </strong
                        >{{ returnFormattedDate(postEntry.created_at) }}
                      </p>
                      <p class="post-entry-detail-p">
                        <strong>Views:</strong> {{ postEntry.views }} <br />
                        <strong>Created By:</strong> {{ postEntry.createdby_name }}<br />
                        <strong>Updeted By:</strong>
                        {{
                          postEntry.updatedby_name === null
                            ? "---"
                            : postEntry.updatedby_name
                        }}
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
      </div>
    </div>
  </Layout>
  <Modal :showModal="openCustomModal" :showCloseBtn="false">
    <template #c-modal-header>
      <h5 v-if="successMsg === ''" class="text-center text-danger">
        {{ deleting ? "Processing your request" : "Please confirm" }}
      </h5>
    </template>
    <template #c-modal-content>
      <div v-if="deleting">
        <LoadingIndicator />
      </div>

      <HandleMsg v-else-if="customErr != ''" infotype="error" :msg="customErr" />
      <HandleMsg v-else-if="successMsg != ''" infotype="success" :msg="successMsg" />
      <div v-else class="text-center">
        <p>
          Delete post with a title
          <strong>{{ postTitle }}</strong
          >? <br />
          please note this can not be undone.
        </p>
        <hr />
        <div class="row">
          <div class="col-md-6 mb-3">
            <AppButton btnStyle="primary" :fullBtn="true" :btnFunc="handleDeletePostNo">
              No
            </AppButton>
          </div>
          <div class="col-md-6 mb-3">
            <AppButton btnStyle="danger" :fullBtn="true" :btnFunc="handleDeletePostYes">
              Yes
            </AppButton>
          </div>
        </div>
      </div>
    </template>
    <template> </template>
  </Modal>
</template>

<script>
import { router } from "@inertiajs/vue3";
import AppLink from "../../shared/AppLink.vue";
import AppButton from "../../shared/AppButton.vue";
import Layout from "../../shared/Layout";
import HandleMsg from "../../shared/HandleMsg.vue";
import LoadingIndicator from "../../shared/LoadingIndicator.vue";
import axios from "../../api/axios";
import {
  limitString,
  returnFormattedDate,
  removeItemFromArrOrObjByValue,
  returnSystemErrorMsg,
} from "../../helper/util";
import Modal from "../../shared/Modal.vue";
export default {
  components: {
    Layout,
    HandleMsg,
    LoadingIndicator,
    AppLink,
    AppButton,
    Modal,
  },

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

    mainResult: {
      type: Object,
      default: {},
    },
    defaultImgLink: {
      type: String,
      default: "",
    },
  },

  data() {
    return {
      isPaginating: false,
      deleting: false,
      mainPostResult: this.mainResult.data,
      initialUrl: this.$page.url,
      postTitle: "",
      postId: "",
      postHasImages: "",
      cloudinaryFolderName: "",
      openCustomModal: false,
      successMsg: "",
      customErr: "",
    };
  },
  methods: {
    limitString,
    returnFormattedDate,
    removeItemFromArrOrObjByValue,
    returnSystemErrorMsg,
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

    handleConfirmDeletePost(
      postToBeDeletedId,
      postToBeDeletedTitle,
      postHasImages,
      cloudinaryFolderName
    ) {
      this.postTitle = postToBeDeletedTitle;
      this.postId = postToBeDeletedId;
      this.postHasImages = postHasImages;
      this.cloudinaryFolderName = cloudinaryFolderName;
      this.openCustomModal = true;

      //console.log(this.openModal);
    },

    handleDeletePostNo() {
      this.openCustomModal = false;
      this.postTitle = "";
      this.postId = "";
      this.successMsg = "";
      this.customErr = "";
    },

    handleDeletePostYes() {
      this.deleting = true;
      setTimeout(async () => {
        //After api call
        try {
          const res = await axios.post("/admin/delete-blog-post", {
            postId: this.postId,
            postHasImages: this.postHasImages,
            cloudinaryFolderName: this.cloudinaryFolderName,
          });

          ///console.log(res);

          if (res?.data?.outcome === true) {
            //set success msg
            this.successMsg = "Post deleted successfully";
            setTimeout(() => {
              this.mainPostResult = removeItemFromArrOrObjByValue(
                this.postId,
                this.mainPostResult,
                "id",
                "obj"
              );
              this.handleDeletePostNo();
            }, 1000);
          } else {
            //Set error meg
            this.customErr = res.data.outcome;
            //console.log("CONTACT ERROR =>", res.data.outcome);
          }
        } catch (err) {
          this.customErr = this.returnSystemErrorMsg();
          //console.log("CONTACT ERR =>", err);
        } finally {
          this.deleting = false;
        }
      }, 2000);
    },
  },

  mounted() {
    //console.log(this.mainPostResult);
    const observer = new IntersectionObserver((entries) =>
      entries.forEach((entry) => entry.isIntersecting && this.loadMorePosts(), {
        rootMargin: "-150px 0px 0px 0px",
      })
    );

    observer.observe(this.$refs.loadMoreIntersect);
  },
};
</script>
