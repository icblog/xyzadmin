<template>
  <div class="row">
    <div class="col-12">
      <div class="text-right pb-2">
        <AppButton :btnFunc="closeModal" btnStyle="primary">X</AppButton>
      </div>
    </div>
  </div>

  <div class="form-wrapper">
    <section v-show="delete_key_data.is_form_processing">
      <LoadingIndicator />
    </section>

    <section v-show="!delete_key_data.is_form_processing">
      <HandleMsg
        v-if="delete_key_data.custom_err != ''"
        infotype="error"
        :msg="delete_key_data.custom_err"
        customClass="form-responds-msg"
      />
      <HandleMsg
        v-else-if="delete_key_data.custom_success != ''"
        infotype="success"
        :msg="delete_key_data.custom_success"
        customClass="form-responds-msg"
      />
      <form class="mb-4" v-else @submit.prevent="handleDeleteForm">
        <div>
          <p>
            Are you sure you want to delete key
            <span class="bolded">{{ key_data?.name }}</span
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
  key_data: {
    type: Object,
    default: {},
  },
});
const delete_key_data = reactive({
  is_form_processing: false,
  custom_err: "",
  custom_success: "",
});

const closeModal = () => {
  emit("handleModalClose");
};

const handleDeleteForm = async () => {
  try {
    delete_key_data.is_form_processing = true;

    const res = await axios.post("/keys/handle-delete-key", {
      key_id: props.key_data?.id,
    });
    if (res?.data?.error != "") {
      delete_key_data.custom_err = res?.data?.error;
    } else {
      //success
      delete_key_data.custom_success = `Thanks, key ${props.key_data?.name} has been successfully deleted`;
      setTimeout(() => {
        router.get("/view-keys");
      }, 4000);
    }
  } catch (err) {
    //console.log(err);
    delete_key_data.custom_err = returnSystemErrorMsg();
  } finally {
    delete_key_data.is_form_processing = false;
  }
};
</script>
