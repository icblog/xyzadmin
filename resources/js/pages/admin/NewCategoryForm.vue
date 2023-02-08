<template>
  <div class="form-wrapper">
    <section v-if="newCategoryFormData.isFormProcessing"><LoadingIndicator /></section>
    <section v-if="!newCategoryFormData.isFormProcessing">
      <form class="add-category-form" @submit.prevent="handleCreateCategorySubmit">
        <label class="form-label" for="category-name"
          ><span v-show="newCategoryFormData.newCategoryFormSuccessMsg == ''">
            Create new category</span
          >
          <br />
          <span v-if="showCategoryFormErr()" class="text-danger bolded small">{{
            newCategoryFormData.newCategoryFormErrMsg
          }}</span>
          <span
            v-else-if="newCategoryFormData.newCategoryFormSuccessMsg != ''"
            class="text-success bolded"
            >{{ newCategoryFormData.newCategoryFormSuccessMsg }}</span
          >
          <span v-else>Name*</span>
        </label>
        <div
          v-show="newCategoryFormData.newCategoryFormSuccessMsg == ''"
          class="input-group mb-3"
        >
          <input
            type="text"
            v-model="newCategoryFormData.categoryName"
            class="form-control"
            id="category-name"
            @focus="hideCategoryFormErr"
          />
          <div class="input-group-append">
            <AppButton btnType="submit" customClass="btn-primary">Save</AppButton>
          </div>
        </div>
        <p v-show="newCategoryFormData.newCategoryFormSuccessMsg == ''" class="small">
          All fields marked with a * are mandatory
        </p>
      </form>
    </section>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import AppButton from "../../shared/AppButton.vue";
import LoadingIndicator from "../../shared/LoadingIndicator.vue";
import axios from "../../api/axios";
import { returnSystemErrorMsg } from "../../helper/util";

const newCategoryFormData = reactive({
  categoryName: "",
  isFormProcessing: false,
  newCategoryFormErrMsg: "",
  newCategoryFormSuccessMsg: "",
});
const showCategoryFormErr = () => {
  if (newCategoryFormData.newCategoryFormErrMsg != "") {
    return true;
  } else {
    return false;
  }
};

const hideCategoryFormErr = () => {
  newCategoryFormData.newCategoryFormErrMsg = "";
};

const handleCreateCategorySubmit = () => {
  let abort = false;
  if (newCategoryFormData.categoryName == "") {
    abort = true;
    newCategoryFormData.newCategoryFormErrMsg = "*Please enter category name";
  }
  if (!abort) {
    //Post the form
    newCategoryFormData.isFormProcessing = true;
    setTimeout(async () => {
      try {
        const res = await axios.post("/admin/create-catgory", {
          categoryname: newCategoryFormData.categoryName,
        });

        if (res?.data?.outcome === true) {
          newCategoryFormData.newCategoryFormSuccessMsg = "Category created successfully";
          newCategoryFormData.categoryName = "";
          setTimeout(() => {
            router.visit("/admin/categories", { method: "get" });
          }, 500);
        } else {
          //console.log(res);
          newCategoryFormData.newCategoryFormErrMsg = res?.data?.outcome[0];
        }
      } catch (err) {
        newCategoryFormData.newCategoryFormErrMsg = returnSystemErrorMsg();
      } finally {
        newCategoryFormData.isFormProcessing = false;
      }
    }, 1000);
  }
};
</script>
