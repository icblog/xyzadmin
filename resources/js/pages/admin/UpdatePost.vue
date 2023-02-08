<template>
  <Layout pageTitle="admin-update-post">
    <div class="container">
      <div class="row">
        <div class="col-md-10 mx-auto">
          <div class="page-intro-wrapper">
            <h1>Admin update post</h1>
          </div>
          <div class="form-wrapper">
            <section v-if="updatePostFormData.processing"><LoadingIndicator /></section>
            <section v-if="!updatePostFormData.processing">
              <HandleMsg v-if="errors.fail" infotype="error" :msg="errors.fail" />
              <form @submit.prevent="handleUpdatePost">
                <!-- File upload componenet -->
                <FileUpload
                  @updateimages="updateImages"
                  :postImages="updatePostFormData.toSend.images"
                />
                <ExistingPostImages
                  :existingPostImages="updatePostFormData.existingPostImages"
                  @updateExistingimages="updateExistingAndTobeDeletedimages"
                />
                <div class="form-group">
                  <hr />
                  <label class="form-label" for="title">Title*</label>
                  <div class="text-danger small" v-if="errors.title">
                    {{ errors.title }}
                  </div>
                  <input
                    ref="firstInput"
                    v-model="updatePostFormData.toSend.title"
                    type="text"
                    class="form-control"
                    id="title"
                    name="title"
                    maxlength="255"
                    autocomplete="off"
                  />
                </div>

                <!-- Multi Select componenet -->
                <MultiSelect
                  @addorremove="updateCategoryIds"
                  :categoriesResult="categoriesResult"
                  :selectError="errors.selectedCategories"
                  :categoryIds="updatePostFormData.toSend.selectedCategories"
                />

                <!-- Post body componenet -->
                <PostBody
                  v-model="updatePostFormData.toSend.postbody"
                  :postBodyError="errors.postbody"
                />

                <div className="text-center saveorpublish">
                  <div class="text-danger small" v-if="errors.saveorpublish">
                    {{ errors.saveorpublish }}
                  </div>
                  <label className="label-container"
                    >Save post
                    <input
                      v-model="updatePostFormData.toSend.saveorpublish"
                      type="radio"
                      name="saveorpublish"
                      value="saved"
                      :checked="
                        updatePostFormData.toSend.saveorpublish === 'saved' ? true : false
                      "
                    /> </label
                  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label className="label-container"
                    >Publish post
                    <input
                      v-model="updatePostFormData.toSend.saveorpublish"
                      type="radio"
                      name="saveorpublish"
                      value="published"
                      :checked="
                        updatePostFormData.toSend.saveorpublish === 'published'
                          ? true
                          : false
                      "
                    />
                  </label>
                </div>

                <p class="small">All fields marked with a * are mandatory</p>

                <div class="pt-3 text-center">
                  <AppButton btnType="submit" btnStyle="primary">Submit</AppButton>
                </div>
              </form>
            </section>
          </div>
        </div>
        <!-- end row div -->
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import AppButton from "../../shared/AppButton.vue";
import Layout from "../../shared/Layout";
import LoadingIndicator from "../../shared/LoadingIndicator.vue";
import HandleMsg from "../../shared/HandleMsg.vue";
import PostBody from "./PostBody.vue";
import MultiSelect from "./MultiSelect.vue";
import FileUpload from "./FileUpload.vue";
import ExistingPostImages from "./ExistingPostImages.vue";
import { focusOnFirstInput } from "../../helper/util";

let firstInput = ref(null);

const props = defineProps({
  errors: Object,
  categoriesResult: {
    type: Object,
    default: {},
  },

  singlePostResult: {
    type: Object,
    default: {},
  },
});

const updatePostFormData = reactive({
  processing: false,
  existingPostImages: [],
  toSend: {
    postId: props.singlePostResult?.id,
    title: props.singlePostResult?.title,
    previousTitle: props.singlePostResult?.title,
    postbody: props.singlePostResult?.body,
    selectedCategories: [],
    images: [],
    saveorpublish: props.singlePostResult?.status,
    totalNewFiles: 0,
    existingPostImagesTotal: 0,
    existingPostImagesToBeDeleted: [],
    existingPostImagesToBeDeletedLen: 0,
    posthasImages: props.singlePostResult?.has_images,
    hasCategoryChange: "no",
  },
});

const updateCategoryIds = (newSelectedValue) => {
  updatePostFormData.toSend.selectedCategories = newSelectedValue;
  updatePostFormData.toSend.hasCategoryChange = "yes";
};

const updateImages = (newImagesArray) => {
  updatePostFormData.toSend.images = newImagesArray;
  updatePostFormData.toSend.totalNewFiles = updatePostFormData.toSend.images.length;
};

const handleUpdatePost = () => {
  updatePostFormData.processing = true;
  setTimeout(() => {
    router.post("/admin/update-post-save", updatePostFormData.toSend, {
      onFinish: () => {
        updatePostFormData.processing = false;
      },
    });
  }, 2000);
};

const assignSelectedCatgoriesFromDB = () => {
  if (props.singlePostResult != null) {
    let tempCatDataObj = [];
    props.singlePostResult.catNames.forEach((category, i) => {
      tempCatDataObj.push({
        id: Number(props.singlePostResult.catIds[i]),
        name: category,
      });
    });
    updatePostFormData.toSend.selectedCategories = tempCatDataObj;

    //console.log(props.singlePostResult);
  }
};

const assignExistingPostImages = () => {
  if (props.singlePostResult != null && props.singlePostResult.has_images != "no") {
    let existingPostImagesRes = [],
      existingPostImagesUrlArray = props.singlePostResult.imgUrls.split(","),
      existingPostImagesPublicIdsArray = props.singlePostResult.imgPublicIds.split(",");
    for (let i = 0; i < existingPostImagesUrlArray.length; i++) {
      existingPostImagesRes.push({
        imgPublicId: existingPostImagesPublicIdsArray[i],
        imgUrl: existingPostImagesUrlArray[i],
      });
    }

    updatePostFormData.existingPostImages = existingPostImagesRes;
    updatePostFormData.toSend.existingPostImagesTotal = existingPostImagesRes.length;
    //console.log("add", updatePostFormData.existingPostImagesTotal);
  } //End if post has images
};

const updateExistingAndTobeDeletedimages = (existingImgObj) => {
  updatePostFormData.existingPostImages = existingImgObj.resArrObj;
  updatePostFormData.toSend.existingPostImagesToBeDeleted.push(
    existingImgObj.objTobedeleted
  );
  updatePostFormData.toSend.existingPostImagesToBeDeletedLen =
    updatePostFormData.toSend.existingPostImagesToBeDeleted.length;
  updatePostFormData.toSend.existingPostImagesTotal =
    updatePostFormData.toSend.existingPostImagesTotal - 1;
  // console.log("Remove", updatePostFormData.existingPostImagesTotal);
};

onMounted(() => {
  assignSelectedCatgoriesFromDB();
  assignExistingPostImages();
  focusOnFirstInput(firstInput);

  //console.log(props.singlePostResult);
});
</script>
