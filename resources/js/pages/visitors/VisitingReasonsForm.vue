<template>
  <div class="form-wrapper">
    <section v-if="newCARFormData.is_processing"><LoadingIndicator /></section>
    <section v-else>
      <div class="bg-white p-2" v-if="newCARFormData.system_err != ''">
        <span class="text-danger">{{ newCARFormData.system_err }}</span>
      </div>
      <div class="bg-white p-2" v-else-if="newCARFormData.success_msg != ''">
        <span class="text-success">{{ newCARFormData.success_msg }}</span>
      </div>
      <form v-else @submit.prevent="handleCARFormSubmit">
        <label class="form-label">Reason*</label>
        <div v-show="newCARFormData.reason_err != ''" class="small text-danger p-0 m-0">
          {{ newCARFormData.reason_err }}
        </div>
        <div class="input-group mb-3">
          <input
            type="text"
            v-model="newCARFormData.reason"
            class="form-control"
            @focus="() => hideCARFormErr('name')"
          />
          <div class="input-group-append">
            <AppButton btnType="submit" customClass="btn-primary">Save</AppButton>
          </div>
        </div>
        <div>
          <label class="form-label mr-2">Make it a quick reason?*</label>
          <div class="form-check-inline">
            <span class="form-check-label">
              <input
                type="radio"
                class="form-check-input"
                id="no"
                :value="0"
                v-model="newCARFormData.quick_reason"
                @click="() => hideCARFormErr('quick_reason')"
              />No
            </span>
          </div>
          <div class="form-check-inline">
            <span class="form-check-label">
              <input
                type="radio"
                class="form-check-input"
                id="yes"
                :value="1"
                v-model="newCARFormData.quick_reason"
                @click="() => hideCARFormErr('quick_reason')"
              />Yes
            </span>
          </div>
          <div
            v-show="newCARFormData.quick_reason_err != ''"
            class="small text-danger p-0 m-0"
          >
            {{ newCARFormData.quick_reason_err }}
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
  quick_reason: "",
  is_processing: false,
  system_err: "",
  success_msg: "",
  reason_err: "",
  quick_reason_err: "",
});

const hideCARFormErr = (input_name) => {
  if (input_name == "name") {
    newCARFormData.reason_err = "";
  }

  if (input_name == "quick_reason") {
    newCARFormData.quick_reason_err = "";
  }
};

const handleCARFormSubmit = () => {
  let abort = false;
  if (newCARFormData.reason == "") {
    abort = true;
    newCARFormData.reason_err = "*Please enter visiting reason";
  }

  if (newCARFormData.quick_reason === "") {
    abort = true;
    newCARFormData.quick_reason_err = "*Please indicate either to make it a quick reason";
  }

  if (!abort) {
    //Post the form
    newCARFormData.is_processing = true;
    setTimeout(async () => {
      try {
        const res = await axios.post("/visitor/add-reasons", {
          reason: newCARFormData.reason,
          quick_reason: newCARFormData.quick_reason,
        });

        if (res?.data?.error != "") {
          if (res?.data?.error.indexOf("enter visiting") > -1) {
            newCARFormData.reason_err = res?.data?.error;
          } else if (res?.data?.error.indexOf("indicate") > -1) {
            newCARFormData.quick_reason_err = res?.data?.error;
          }
        } else {
          newCARFormData.success_msg = "Reason added successfully";
          setTimeout(() => {
            router.get("/visiting-reasons");
          }, 500);
        }
      } catch (err) {
        newCARFormData.reason_err = returnSystemErrorMsg();
      } finally {
        newCARFormData.is_processing = false;
      }
    }, 1000);
  }
};
</script>
