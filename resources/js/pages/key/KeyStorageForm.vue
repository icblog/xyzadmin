<template>
  <div class="form-wrapper">
    <section v-if="new_storage_data.is_processing"><LoadingIndicator /></section>
    <section v-if="!new_storage_data.is_processing">
      <form @submit.prevent="handleFormSubmit">
        <label class="form-label"
          ><span v-show="new_storage_data.success_msg == ''"> Add new storage</span>
          <br />
          <br />
          <span v-if="showFormErr()" class="text-danger bolded small">{{
            new_storage_data.err_msg
          }}</span>
          <span
            v-else-if="new_storage_data.success_msg != ''"
            class="text-success bolded"
            >{{ new_storage_data.success_msg }}</span
          >
          <span v-else>Storage*</span>
        </label>
        <div v-show="new_storage_data.success_msg == ''" class="input-group mb-3">
          <input
            type="text"
            v-model="new_storage_data.storage"
            class="form-control"
            @focus="hideFormErr"
          />
          <div class="input-group-append">
            <AppButton btnType="submit" customClass="btn-primary">Save</AppButton>
          </div>
        </div>
        <p v-show="new_storage_data.success_msg == ''" class="small">
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

const new_storage_data = reactive({
  storage: "",
  is_processing: false,
  err_msg: "",
  success_msg: "",
});
const showFormErr = () => {
  if (new_storage_data.err_msg != "") {
    return true;
  } else {
    return false;
  }
};

const hideFormErr = () => {
  new_storage_data.err_msg = "";
};

const handleFormSubmit = () => {
  let abort = false;
  if (new_storage_data.storage == "") {
    abort = true;
    new_storage_data.err_msg = "*Please enter storage name before saving thanks";
  }
  if (!abort) {
    //Post the form
    new_storage_data.is_processing = true;
    setTimeout(async () => {
      try {
        const res = await axios.post("/keys/add-storage", {
          storage: new_storage_data.storage,
        });

        if (res?.data?.error != "") {
          new_storage_data.err_msg = res?.data?.error;
        } else {
          new_storage_data.success_msg = "storage added successfully";
          new_storage_data.storage = "";
          setTimeout(() => {
            router.get("/keys/storage");
          }, 500);
        }
      } catch (err) {
        new_storage_data.err_msg = returnSystemErrorMsg();
      } finally {
        new_storage_data.is_processing = false;
      }
    }, 1000);
  }
};
</script>
