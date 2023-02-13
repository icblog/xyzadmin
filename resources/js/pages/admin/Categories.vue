<template>
  <Layout pageTitle="admin-all-categories">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="page-intro-wrapper pb-3">
            <div class="row">
              <div class="col-md-7">
                <h1>Admin categories</h1>
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

            <div class="row mt-5">
              <div class="col-md-8 mx-auto">
                <!-- Add new category form -->
                <NewCategoryform />
                <div class="form-wrapper">
                  <div
                    v-if="reactiveData.oldCategoriesData.length > 0"
                    ref="loadMoreIntersect"
                    class="admin-catgory-result-wrapper"
                  >
                    <h5 class="pb-2">Already saved categories</h5>
                    <!-- Filter category -->
                    <div class="admin-catgory-result-wrapper-form-input">
                      <LocalSearch
                        :oldResultObj="reactiveData.oldCategoriesData"
                        whatToCheck="name"
                        @updateCategoriesResult="returnFilteredCategoriesResult"
                      />
                    </div>

                    <section v-if="reactiveData.categoriesResult.length > 0">
                      <div
                        v-for="(category, index) in reactiveData.categoriesResult"
                        :class="{
                          'admin-category-detail-wrapper p-2 box-shadow mb-4': true,
                          'admin-category-detail-wrapper-active': returnIfInputIsActive(
                            category.id
                          ),
                        }"
                        :key="category.id"
                      >
                        <div
                          class="small text-danger"
                          v-if="showErrMsgIfNotEmpty(category.id)"
                        >
                          {{ reactiveData.customErr }}
                        </div>
                        <div class="input-group">
                          <input
                            ref="categoriesResultInput"
                            :value="
                              returnIfInputIsActive(category.id)
                                ? reactiveData.categoryTobeProcessNewValue
                                : category.name
                            "
                            :type="returnIfInputIsActive(category.id) ? 'text' : 'button'"
                            @input="handleCategoryInputChange"
                            @focus="hideCustomErrorOnFocus"
                            :class="{
                              'form-control admin-all-category-input': true,
                              'admin-all-category-input-active mb-1': returnIfInputIsActive(
                                category.id
                              ),
                            }"
                          />
                          <div class="input-group-append">
                            <span v-if="returnIfInputIsActive(category.id)">
                              <!-- Okay button -->
                              <AppButton
                                btnStyle="success"
                                :btnFunc="() => handleUpdateCategory(category.id, index)"
                              >
                                <span v-if="returnIfCategoryIsEditing(category.id)"
                                  >Processing....</span
                                >
                                <span
                                  v-else-if="returnIfCategoryEditsuccess(category.id)"
                                  >{{ reactiveData.customSuccess }}</span
                                >
                                <span v-else><i class="fas fa-check"></i></span>
                              </AppButton>
                              <!-- Cancel button -->
                              <AppButton
                                btnStyle="warn"
                                :hideBtn="hideCancelBtn(category.id)"
                                :btnFunc="handleCancelBtn"
                              >
                                <span><i class="fas fa-times"></i></span>
                              </AppButton>
                            </span>
                            <span v-else>
                              <!-- Edit button -->
                              <AppButton
                                btnStyle="primary2"
                                :hideBtn="
                                  returnIfCategoryIsDeleting(category.id) ||
                                  returnIfCategoryIsDeleteSuccess(category.id)
                                "
                                :btnFunc="
                                  () => handleEditBtn(index, category.id, category.name)
                                "
                              >
                                <span><i class="fas fa-edit"></i></span>
                              </AppButton>
                              <!-- Delete button -->
                              <AppButton
                                :btnStyle="
                                  returnIfCategoryIsDeleting(category.id)
                                    ? 'secondary'
                                    : returnIfCategoryIsDeleteSuccess(category.id)
                                    ? 'success'
                                    : 'danger'
                                "
                                :btnFunc="
                                  () =>
                                    handleDeleteCategoryYes(category.id, category.name)
                                "
                              >
                                <span v-if="returnIfCategoryIsDeleting(category.id)"
                                  >Processing...</span
                                >

                                <span
                                  v-else-if="returnIfCategoryIsDeleteSuccess(category.id)"
                                  >{{ reactiveData.customSuccess }}</span
                                >
                                <span v-else><i class="fas fa-trash"></i></span>
                              </AppButton>
                            </span>
                          </div>
                        </div>
                        <p>
                          Created date:
                          <span className="admin-detail-value-span">{{
                            category.created_at
                          }}</span
                          ><br />
                          Created by:
                          <span className="admin-detail-value-span">{{
                            category.createdby_name
                          }}</span
                          ><br />
                          Updated date:
                          <span className="admin-detail-value-span">{{
                            category.updated_at == category.created_at
                              ? "---"
                              : category.updated_at
                          }}</span
                          ><br />
                          Updated by: <span className="admin-detail-value-span"></span
                          ><br />
                        </p>
                      </div>
                    </section>
                    <section v-else>
                      <HandleMsg infotype="info" msg="No category found" />
                    </section>
                  </div>

                  <!-- loadmore result here -->
                  <span ref="loadMoreCategoryIntersect" />
                  <div v-if="reactiveData.isPaginating" class="text-center pt-4 pb-4">
                    <LoadingIndicator />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from "vue";
import { router } from "@inertiajs/vue3";
import AppLink from "../../shared/AppLink.vue";
import AppButton from "../../shared/AppButton.vue";
import Layout from "../../shared/Layout";
import LoadingIndicator from "../../shared/LoadingIndicator.vue";
import HandleMsg from "../../shared/HandleMsg.vue";
import NewCategoryform from "./NewCategoryForm.vue";
import LocalSearch from "../../shared/LocalSearch.vue";
import axios from "../../api/axios";
import { removeItemFromArrOrObjByValue, returnSystemErrorMsg } from "../../helper/util";

let categoriesResultInput = ref(null),
  loadMoreCategoryIntersect = ref(null);

const props = defineProps({
  errors: Object,
  categoriesResult: {
    type: Object,
    default: {},
  },
});

const reactiveData = reactive({
  categoriesResult: props.categoriesResult?.data,
  oldCategoriesData: props.categoriesResult?.data,
  categoryTobeProcessId: "",
  categoryTobeProcessNewValue: "",
  categoryTobeProcessOldValue: "",
  showOkAndCancelBtn: false,
  customErr: "",
  isProcessing: false,
  isPaginating: false,
  customSuccess: "",
  initialUrl: props.categoriesResult?.path,
  deleting: false,
  categoryDeleted: false,
  pageNumber: 1,
  localSearchInprogress: false,
});

const returnFilteredCategoriesResult = ({ arrObj, newValue }) => {
  reactiveData.localSearchInprogress = true;
  if (newValue == "") {
    reactiveData.localSearchInprogress = false;
  }
  reactiveData.categoriesResult = arrObj;
};

const handleCancelBtn = () => {
  reactiveData.categoryTobeProcessId = "";
  reactiveData.categoryTobeProcessNewValue = "";
  reactiveData.categoryTobeProcessOldValue = "";
  reactiveData.customErr = "";
  reactiveData.customSuccess = "";
  reactiveData.showOkAndCancelBtn = false;
  reactiveData.categoryDeleted = false;
};

const handleEditBtn = (index, categoryId, textValue) => {
  reactiveData.categoryTobeProcessId = categoryId;
  reactiveData.categoryTobeProcessNewValue = textValue;
  reactiveData.categoryTobeProcessOldValue = textValue;
  reactiveData.showOkAndCancelBtn = true;
  categoriesResultInput.value[index].focus();
  // console.log(categoriesResultInput.value[index]);
};

const showErrMsgIfNotEmpty = (categoryId) => {
  let isEmptyMsg = false;
  if (reactiveData.customErr != "" && reactiveData.categoryTobeProcessId == categoryId) {
    isEmptyMsg = true;
  }
  return isEmptyMsg;
};

const returnIfInputIsActive = (categoryId) => {
  let isCatgoryEditInputActive = false;
  if (
    reactiveData.showOkAndCancelBtn &&
    reactiveData.categoryTobeProcessId == categoryId
  ) {
    isCatgoryEditInputActive = true;
  }
  return isCatgoryEditInputActive;
};

const returnIfCategoryIsDeleting = (categoryId) => {
  let tempDeleting = false;
  if (reactiveData.deleting && reactiveData.categoryTobeProcessId == categoryId) {
    tempDeleting = true;
  }
  return tempDeleting;
};

const returnIfCategoryIsDeleteSuccess = (categoryId) => {
  let tempSuccess = false;
  if (
    reactiveData.categoryDeleted &&
    reactiveData.customSuccess != "" &&
    reactiveData.categoryTobeProcessId == categoryId
  ) {
    tempSuccess = true;
  }
  return tempSuccess;
};

const returnIfCategoryIsEditing = (categoryId) => {
  let istempIsprocessing = false;
  if (reactiveData.isProcessing && reactiveData.categoryTobeProcessId == categoryId) {
    istempIsprocessing = true;
  }
  return istempIsprocessing;
};

const returnIfCategoryEditsuccess = (categoryId) => {
  let istempSuccess = false;
  if (
    reactiveData.customSuccess != "" &&
    !reactiveData.isProcessing &&
    reactiveData.categoryTobeProcessId == categoryId
  ) {
    istempSuccess = true;
  }
  return istempSuccess;
};

const hideCancelBtn = (categoryId) => {
  let istempSuccess = false;
  if (
    reactiveData.customSuccess != "" &&
    reactiveData.categoryTobeProcessId == categoryId
  ) {
    istempSuccess = true;
  }
  return istempSuccess;
};

const handleCategoryInputChange = (e) => {
  reactiveData.categoryTobeProcessNewValue = e.target.value;
  //console.log(e.target.value);
};

const hideCustomErrorOnFocus = () => {
  if (reactiveData.customErr != "") {
    reactiveData.customErr = "";
  }
};

const handleUpdateCategory = async (categoryId, index) => {
  let abort = false;
  if (reactiveData.categoryTobeProcessNewValue == "") {
    abort = true;
    reactiveData.customErr = "A new name is required before saving thank you";
  }

  if (
    reactiveData.categoryTobeProcessNewValue == reactiveData.categoryTobeProcessOldValue
  ) {
    abort = true;
    reactiveData.customErr = "Please make a change before saving thank you";
  }

  if (!abort) {
    reactiveData.isProcessing = true;

    try {
      const res = await axios.post("/admin/update-category", {
        categoryId: categoryId,
        editedCategoryName: reactiveData.categoryTobeProcessNewValue,
        oldCategoryname: reactiveData.categoryTobeProcessOldValue,
      });

      if (res?.data?.outcome === true) {
        //success
        reactiveData.customSuccess = "Success";
        setTimeout(() => {
          handleCancelBtn();
          reactiveData.categoriesResult[index] = res?.data?.updatedCategoryRecord[0];
          reactiveData.oldCategoriesData = reactiveData.categoriesResult;
        }, 1000);
      } else {
        //Set error message

        reactiveData.customErr = res?.data?.outcome[0];
      }
    } catch (err) {
      reactiveData.customErr = returnSystemErrorMsg();
      //console.log("UPDATE CATEGORY ADMIN ERR =>", err);
    } finally {
      reactiveData.isProcessing = false;
    }
  } //end if about is false
};

const loadMoreCategories = () => {
  if (!reactiveData.localSearchInprogress) {
    if (props.categoriesResult.next_page_url === null) {
      return;
    }

    router.get(
      props.categoriesResult.next_page_url,
      {},
      {
        preserveState: true,
        preserveScroll: true,
        only: ["categoriesResult"],
        onStart: () => {
          reactiveData.isPaginating = true;
        },
        onFinish: () => {
          reactiveData.isPaginating = false;
        },
        onSuccess: () => {
          window.history.replaceState({}, "", reactiveData.initialUrl);
          reactiveData.categoriesResult = [
            ...reactiveData.categoriesResult,
            ...props.categoriesResult?.data,
          ];
          reactiveData.oldCategoriesData = reactiveData.categoriesResult;
        },
      }
    );
  }
};

const handleDeleteCategoryYes = (categoryId, categoryname) => {
  if (
    window.confirm(
      `Delete category (${categoryname}) ? please note this can not be undone`
    )
  ) {
    reactiveData.categoryTobeProcessId = categoryId;
    reactiveData.deleting = true;

    setTimeout(async () => {
      try {
        const res = await axios.post("/admin/delete-category", {
          categoryId: categoryId,
        });
        //res.data.outcome can be boolean or error message
        if (res?.data?.outcome === true) {
          //set success msg
          reactiveData.customSuccess = "Success";
          reactiveData.categoryDeleted = true;
          setTimeout(() => {
            handleCancelBtn();
            reactiveData.categoriesResult = removeItemFromArrOrObjByValue(
              categoryId,
              reactiveData.categoriesResult,
              "id",
              "obj"
            );

            reactiveData.oldCategoriesData = reactiveData.categoriesResult;
          }, 1000);
        } else {
          //Set error meg
          reactiveData.customErr = res.data.outcome;
          //console.log("CONTACT ERROR =>", res.data.outcome);
        }
      } catch (err) {
        reactiveData.customErr = returnSystemErrorMsg();
        //console.log("CONTACT ERR =>", err);
      } finally {
        reactiveData.deleting = false;
      }
    }, 1500);
  } //End window confirm
};

onMounted(() => {
  // console.log(props.categoriesResult);

  const observer = new IntersectionObserver((entries) =>
    entries.forEach((entry) => entry.isIntersecting && loadMoreCategories(), {
      rootMargin: "-150px 0px 0px 0px",
    })
  );

  observer.observe(loadMoreCategoryIntersect.value);
});
</script>
