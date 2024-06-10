<template>
  <div class="row">
    <div class="col-12">
      <div class="text-right pb-2">
        <AppButton :btnFunc="closeModal" btnStyle="primary">X</AppButton>
      </div>
    </div>
  </div>

  <div class="form-wrapper">
    <section v-show="delete_locker_data.is_form_processing">
      <LoadingIndicator />
    </section>

    <section v-show="!delete_locker_data.is_form_processing">
      <HandleMsg
        v-if="delete_locker_data.custom_err != ''"
        infotype="error"
        :msg="delete_locker_data.custom_err"
        customClass="form-responds-msg"
      />
      <HandleMsg
        v-else-if="delete_locker_data.custom_success != ''"
        infotype="success"
        :msg="delete_locker_data.custom_success"
        customClass="form-responds-msg"
      />
      <form class="mb-4" v-else @submit.prevent="handleDeleteForm">
        <div>
          <p>
            Are you sure you want to delete locker
            <span class="bolded">{{ locker?.name }}</span
            >? please note this can not be undone
          </p>
          <hr />
          <div class="text-center">
            <AppButton customClass="mr-5" :btnFunc="closeModal" btnStyle="warn"
              >No</AppButton
            >
            <AppButton btnType="submit" btnStyle="primary2">Yes</AppButton>
          </div>
        </div>
      </form>
    </section>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import LoadingIndicator from "../../shared/LoadingIndicator";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import { returnSystemErrorMsg } from "../../helper/util";
import axios from "../../api/axios";

const emit = defineEmits(["handleModalClose"]);

const props = defineProps({
  locker: {
    type: Object,
    default: {},
  },
});
const delete_locker_data = reactive({
  is_form_processing: false,
  custom_err: "",
  custom_success: "",
});

const closeModal = () => {
  emit("handleModalClose");
};

const handleDeleteForm = async () => {
  try {
    delete_locker_data.is_form_processing = true;

    const res = await axios.post("/lockers/handle-delete-locker", {
      locker_id: props.locker?.id,
    });
    if (res?.data?.error != "") {
      delete_locker_data.custom_err = res?.data?.error;
    } else {
      //success
      delete_locker_data.custom_success = `Thanks, locker ${props.locker?.name} has been successfully deleted`;
      setTimeout(() => {
        router.get("/lockers");
      }, 4000);
    }
  } catch (err) {
    //console.log(err);
    delete_locker_data.custom_err = returnSystemErrorMsg();
  } finally {
    delete_locker_data.is_form_processing = false;
  }
};
</script>
