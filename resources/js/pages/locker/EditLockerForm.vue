<template>
  <div class="row">
    <div class="col-12">
      <div class="text-right pb-2">
        <AppButton :btnFunc="closeModal" btnStyle="primary">X</AppButton>
      </div>
    </div>
  </div>

  <div class="form-wrapper">
    <section v-show="edit_locker_data.is_form_processing">
      <LoadingIndicator />
    </section>

    <section v-show="!edit_locker_data.is_form_processing">
      <HandleMsg
        v-if="edit_locker_data.custom_err != ''"
        infotype="error"
        :msg="edit_locker_data.custom_err"
        customClass="form-responds-msg"
      />
      <HandleMsg
        v-else-if="edit_locker_data.custom_success != ''"
        infotype="success"
        :msg="edit_locker_data.custom_success"
        customClass="form-responds-msg"
      />
      <form class="mb-4" v-else @submit.prevent="handleEditLockerForm">
        <div class="text-center">
          <label class="form-label mt-0 mb-0">Edit locker {{ locker?.name }}</label>
          <hr class="mt-1 mb-1" />
        </div>
        <div class="form-group">
          <label class="form-label" for="name">Locker name/number*</label>
          <div
            v-show="edit_locker_data.form_error.name_err != ''"
            class="small text-danger p-0 m-0"
          >
            {{ edit_locker_data.form_error.name_err }}
          </div>
          <input
            type="text"
            :value="locker?.name"
            class="form-control"
            maxlength="255"
            @input="(e) => updateFormInput(e, 'name')"
            @focus="() => removeFormErr('name')"
          />
        </div>
        <div>
          <label class="form-label mr-2" for="status">Status: </label>
          <span
            :class="{
              'badge font-weight-bold no-border-radius': true,
              'badge-warning': locker.locker_status == 2,
              'badge-danger': locker.locker_status == 1,
              'badge-success': locker.locker_status == 0,
            }"
          >
            {{
              locker.locker_status == 2
                ? "Broken"
                : locker.locker_status == 1
                ? "Inuse"
                : "Free"
            }}</span
          >
          <div class="pb-2">
            <div class="form-check-inline">
              <span class="form-check-label">
                <input
                  type="radio"
                  name="status"
                  id="status"
                  class="form-check-input"
                  :value="0"
                  :checked="locker.locker_status === 0 ? true : false"
                  @input="(e) => updateFormInput(e, 'status')"
                />Free
              </span>
            </div>
            <!-- <div class="form-check-inline">
              <span class="form-check-label">
                <input
                  type="radio"
                  name="status"
                  class="form-check-input"
                  :value="1"
                  :checked="locker.locker_status === 1 ? true : false"
                  @input="(e) => updateFormInput(e, 'status')"
                />Inuse
              </span>
            </div> -->

            <div class="form-check-inline">
              <span class="form-check-label">
                <input
                  type="radio"
                  name="status"
                  class="form-check-input"
                  :value="2"
                  :checked="locker.locker_status === 2 ? true : false"
                  @input="(e) => updateFormInput(e, 'status')"
                />Broken
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label"
            >Comment:
            <span class="optional">(Optional)</span>
          </label>
          <div
            v-show="edit_locker_data.form_error.comment_err != ''"
            class="small text-danger p-0 m-0"
          >
            {{ edit_locker_data.form_error.comment_err }}
          </div>
          <textarea
            :value="locker?.comment"
            class="form-control"
            rows="1"
            cols="10"
            @input="(e) => updateFormInput(e, 'comment')"
            @focus="() => removeFormErr('comment')"
          ></textarea>
        </div>
        <p class="small pt-1">Please note, all fields marked with a * are mandatory</p>
        <div class="text-center">
          <AppButton customClass="mr-5" :btnFunc="closeModal" btnStyle="warn"
            >Cancel</AppButton
          >
          <AppButton btnType="submit" btnStyle="primary2">Save</AppButton>
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
const edit_locker_data = reactive({
  form_data: {
    name: "",
    old_locker_name: "",
    comment: "",
    status: "",
    old_status: "",
    action: "edit",
  },
  form_error: {
    name_err: "",
    comment_err: "",
  },
  has_name_number_changed: false,
  has_comment_changed: false,
  has_status_changed: false,
  is_form_processing: false,
  custom_err: "",
  custom_success: "",
});

const closeModal = () => {
  edit_locker_data.form_data.name = "";
  edit_locker_data.form_data.comment = "";
  edit_locker_data.form_data.status = "";
  edit_locker_data.has_name_number_changed = false;
  edit_locker_data.has_comment_changed = false;
  edit_locker_data.has_status_changed = false;
  emit("handleModalClose");
};
const removeFormErr = (input_name) => {
  if (input_name == "name") {
    edit_locker_data.form_error.name_err = "";
  }

  if (input_name == "comment") {
    edit_locker_data.form_error.comment_err = "";
  }
};

const updateFormInput = (e, input_name) => {
  if (input_name == "name") {
    edit_locker_data.form_data.name = e.target.value;
    edit_locker_data.has_name_number_changed = true;
  }

  if (input_name == "comment") {
    edit_locker_data.form_data.comment = e.target.value;
    edit_locker_data.has_comment_changed = true;
  }

  if (input_name == "status") {
    edit_locker_data.form_data.status = Number(e.target.value);
    edit_locker_data.has_status_changed = true;
  }
};

const checkForFormError = () => {
  let abort = false,
    errors_arr = [];

  if (edit_locker_data.form_data.name == "") {
    abort = true;
    errors_arr.push("Locker name or number can not be empty");
  }

  return {
    abort,
    errors_arr,
  };
};

const assignFormErr = (errorsArr) => {
  // console.log(errorsArr);
  errorsArr.forEach((error) => {
    if (error.toLowerCase().indexOf("name") > -1) {
      edit_locker_data.form_error.name_err = error;
    }

    if (error.toLowerCase().indexOf("comment") > -1) {
      edit_locker_data.form_error.comment_err = error;
    }
  });
};

const handleEditLockerForm = async () => {
  edit_locker_data.form_data.locker_id = props.locker?.id;
  edit_locker_data.form_data.old_locker_name = props.locker?.name;
  edit_locker_data.form_data.old_status = props.locker?.locker_status;

  if (!edit_locker_data.has_name_number_changed) {
    edit_locker_data.form_data.name = props.locker?.name;
  }
  if (!edit_locker_data.has_comment_changed) {
    edit_locker_data.form_data.comment = props.locker?.comment;
  }

  let error_check = checkForFormError();

  if (error_check.abort) {
    assignFormErr(error_check.errors_arr);
  } else {
    try {
      if (!edit_locker_data.has_status_changed) {
        edit_locker_data.form_data.status = props.locker?.locker_status;
      }
      edit_locker_data.is_form_processing = true;

      const res = await axios.post(
        "/lockers/handle-assign-locker",
        edit_locker_data.form_data
      );
      if (res?.data?.errors.length > 0) {
        assignFormErr(res?.data?.errors);
      } else {
        //success
        edit_locker_data.custom_success = `Thanks, locker ${props.locker?.name} has been successfully updated`;
        setTimeout(() => {
          router.get("/lockers");
        }, 4000);
      }
    } catch (err) {
     
      edit_locker_data.custom_err = returnSystemErrorMsg();
    } finally {
      edit_locker_data.is_form_processing = false;
    }
  } // end error check
};
</script>
