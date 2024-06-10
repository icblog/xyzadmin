<template>
  <div class="form-wrapper">
    <section v-if="newCARFormData.is_processing"><LoadingIndicator /></section>
    <section v-if="!newCARFormData.is_processing">
      <form @submit.prevent="handleCARFormSubmit">
        <label class="form-label"
          ><span v-show="newCARFormData.success_msg == ''"> Add new absence reason</span>
          <br />
          <br />
          <span v-if="showCARFormErr()" class="text-danger bolded small">{{
            newCARFormData.err_msg
          }}</span>
          <span
            v-else-if="newCARFormData.success_msg != ''"
            class="text-success bolded"
            >{{ newCARFormData.success_msg }}</span
          >
          <span v-else>Reason*</span>
        </label>
        <div v-show="newCARFormData.success_msg == ''" class="input-group mb-3">
          <input
            type="text"
            v-model="newCARFormData.reason"
            class="form-control"
            @focus="hideCARFormErr"
          />
          <div class="input-group-append">
            <AppButton btnType="submit" customClass="btn-primary">Save</AppButton>
          </div>
        </div>
        <p v-show="newCARFormData.success_msg == ''" class="small">
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

const newCARFormData = reactive({
  reason: "",
  is_processing: false,
  err_msg: "",
  success_msg: "",
});
const showCARFormErr = () => {
  if (newCARFormData.err_msg != "") {
    return true;
  } else {
    return false;
  }
};

const hideCARFormErr = () => {
  newCARFormData.err_msg = "";
};

const handleCARFormSubmit = () => {
  let abort = false;
  if (newCARFormData.reason == "") {
    abort = true;
    newCARFormData.err_msg = "*Please enter absence reason before saving thanks";
  }
  if (!abort) {
    //Post the form
    newCARFormData.is_processing = true;
    setTimeout(async () => {
      try {
        const res = await axios.post("/absence/add-reasons", {
          reason: newCARFormData.reason,
        });

        if (res?.data?.error != "") {
          newCARFormData.err_msg = res?.data?.error;
        } else {
          newCARFormData.success_msg = "Reason added successfully";
          newCARFormData.reason = "";
          setTimeout(() => {
            router.get("/absence/reasons");
          }, 500);
        }
      } catch (err) {
        newCARFormData.err_msg = returnSystemErrorMsg();
      } finally {
        newCARFormData.is_processing = false;
      }
    }, 1000);
  }
};
</script>
