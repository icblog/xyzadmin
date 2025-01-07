<template>
  <Layout pageTitle="edit-key" pageIntro="Edit key">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="6" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="form-wrapper">
              <section v-if="edit_key_data.is_form_processing">
                <LoadingIndicator />
              </section>

              <section v-else>
                <form @submit.prevent="handleAddKeyForm">
                  <HandleMsg
                    v-if="edit_key_data.custom_err != ''"
                    infotype="error"
                    :msg="edit_key_data.custom_err"
                    customClass="form-responds-msg"
                  />
                  <div v-else-if="edit_key_data.custom_success != ''">
                    <HandleMsg
                      infotype="success"
                      :msg="edit_key_data.custom_success"
                      customClass="form-responds-msg"
                    />
                    <AfterSuccessBtn
                      add_link_name="/keys/add"
                      redirect_link_name="/view-keys"
                      click_action_add="add_keys"
                      click_action_redirect="view_keys"
                      add_btn_name="Add another key"
                      redirect_btn_name="View keys"
                      @updateSuccessCancelTimer="updateSuccessCancelTimer"
                    />
                  </div>
                  <div v-else>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="name">Key name/number*</label>
                          <div
                            v-show="edit_key_data.errors.name_err != ''"
                            class="small text-danger p-0 m-0"
                          >
                            {{ edit_key_data.errors.name_err }}
                          </div>
                          <input
                            ref="firstInput"
                            type="text"
                            id="name"
                            v-model="edit_key_data.form_data.name"
                            class="form-control"
                            maxlength="255"
                            @focus="() => removeFormErr('name')"
                          />
                        </div>
                        <!-- end div col md 6 -->
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Describe what the key is for* </label>
                          <div
                            v-show="edit_key_data.errors.desc_err != ''"
                            class="small text-danger p-0 m-0"
                          >
                            {{ edit_key_data.errors.desc_err }}
                          </div>
                          <textarea
                            v-model="edit_key_data.form_data.description"
                            class="form-control"
                            rows="1"
                            cols="10"
                            @focus="() => removeFormErr('desc')"
                          ></textarea>
                        </div>
                        <!-- end div col md 6 -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label"
                            >Storage:
                            {{ edit_key_data.form_data.key_storage_name }}</label
                          >
                          <OptionElementInput
                            v-if="edit_key_data.key_storage_obj.length > 0"
                            :defaultOptionSelected="
                              edit_key_data.form_data.key_storage_name
                            "
                            :resultObj="edit_key_data.key_storage_obj"
                            :inputErrMsg="edit_key_data.errors.storage_err"
                            :disabledInput="true"
                            whatToget="id"
                            :inputFocusFunc="() => removeFormErr('key_storage')"
                            @updateSelectedOptionInput="updateSelectedKeyStorage"
                          />
                        </div>
                        <!-- end div col md 6 -->
                      </div>
                      <div class="col-md-6">
                        <label class="form-label"
                          >Status:
                          <span
                            :class="{
                              'badge font-weight-bold no-border-radius': true,
                              'badge-success': edit_key_data.form_data.key_status == 0,
                              'badge-danger': edit_key_data.form_data.key_status == 1,
                              'badge-warn': edit_key_data.form_data.key_status == 2,
                            }"
                            >{{ returnKeyStatus() }}</span
                          ></label
                        >

                        <OptionElementInput
                          v-if="edit_key_data.key_storage_obj.length > 0"
                          arrType="arr"
                          :defaultOptionSelected="returnKeyStatus()"
                          :resultObj="key_status_arr"
                          :disabledInput="true"
                          :inputFocusFunc="() => removeFormErr('key_status')"
                          @updateSelectedOptionInput="handleStatusChange"
                        />

                        <!-- end div col md 6 -->
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label"
                            >Comment
                            <span class="optional">(Optional)</span>
                          </label>
                          <div
                            v-show="edit_key_data.errors.comment_err != ''"
                            class="small text-danger p-0 m-0"
                          >
                            {{ edit_key_data.errors.comment_err }}
                          </div>
                          <textarea
                            v-model="edit_key_data.form_data.comment"
                            class="form-control"
                            rows="1"
                            cols="10"
                            @focus="() => removeFormErr('comment')"
                          ></textarea>
                        </div>
                        <!-- end div col md 12 -->
                      </div>
                      <!-- end div row -->
                    </div>

                    <p class="small pt-1 pb-0 mb-0">
                      Key authorization, select department or co-workers that are allowed
                      access to this key. Note: you can select multiple department or
                      co-workers.
                    </p>
                    <hr class="m-0 p-0" />
                    <div
                      v-show="edit_key_data.errors.department_or_coworker_err"
                      class="small text-danger p-0 m-0"
                    >
                      {{ edit_key_data.errors.department_or_coworker_err }}
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <!-- Multi Select componenet department-->
                        <MultiSelect
                          v-if="edit_key_data.department_obj.length > 0"
                          labelName="Select department"
                          :disabledInput="true"
                          whatToget="id"
                          :resultObj="edit_key_data.department_obj"
                          :defaultOptionSelected="
                            edit_key_data.form_data.selected_department
                          "
                          @updateSelectedOptionInput="updateSelectedDepartment"
                          :inputFocusFunc="() => removeFormErr('department')"
                        />

                        <!-- end div col md 6 -->
                      </div>
                      <div class="col-md-6">
                        <!-- Multi Select componenet coworker-->
                        <CoWorkerMultiSelect
                          :defaultOptionSelected="
                            edit_key_data.form_data.selected_coworker
                          "
                          whatToget="id"
                          labelName="Search and select co-workers"
                          @updateSelectedOptionInput="updateSelectedCoworker"
                          :inputFocusFunc="() => removeFormErr('coworker')"
                        />

                        <!-- end div col md 6 -->
                      </div>
                      <!-- end div row -->
                    </div>

                    <p class="small pt-1">
                      Please note, all fields marked with a * are mandatory
                    </p>
                    <!-- <p
                      v-show="!edit_key_data.has_changes_been_made"
                      class="text-danger text-center"
                    >
                      Please make some changes before saving thank you.
                    </p> -->
                    <hr class="m-0 p-0" />
                    <div class="pt-3 row">
                      <div class="col-4">
                        <AppLink
                          className="btn-warning btn no-border-radius"
                          linkUrl="/view-keys"
                        >
                          Cancel
                        </AppLink>
                      </div>
                      <div class="col-8 text-center">
                        <AppButton :fullBtn="true" btnType="submit" btnStyle="primary"
                          >Submit</AppButton
                        >
                      </div>
                    </div>
                  </div>
                </form>
              </section>
              <!-- end form wrapper -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import AppLink from "../../shared/AppLink";
import AfterSuccessBtn from "../../shared/AfterSuccessBtn";
import LoadingIndicator from "../../shared/LoadingIndicator";
import OptionElementInput from "../../shared/OptionElementInput";
import MultiSelect from "../../shared/MultiSelect";
import CoWorkerMultiSelect from "../../shared/CoWorkerMultiSelect";
import {
  focusOnFirstInput,
  returnSystemErrorMsg,
  scrollToTopOrBottomOfPage,
} from "../../helper/util";
import axios from "../../api/axios";
const firstInput = ref(null);
const key_status_arr = ["Free", "Inuse", "Lost"];

const props = defineProps({
  errors: Object,
  key_storage_res: {},
  department_res: {},
  key_res: {},
  coworker_key_auth_res: {},
  depart_key_auth_res: {},
});

const edit_key_data = reactive({
  form_data: {
    key_id: props.key_res?.id,
    name: props.key_res?.name,
    old_name: props.key_res?.name,
    description: props.key_res?.description,
    key_storage_id: props.key_res?.storage_id,
    old_key_storage_id: props.key_res?.storage_id,
    key_storage_name: props.key_res?.storage_name,
    old_key_storage_name: props.key_res?.storage_name,
    comment: props.key_res?.comment == null ? "" : props.key_res?.comment,
    key_status: props.key_res?.status,
    selected_department: props.depart_key_auth_res,
    selected_coworker: props.coworker_key_auth_res,
  },

  errors: {
    name_err: "",
    desc_err: "",
    comment_err: "",
    storage_err: "",
    department_or_coworker_err: "",
  },

  key_storage_obj: props.key_storage_res,
  department_obj: props.department_res,
  custom_err: "",
  custom_success: "",
  is_form_processing: false,
  cancel_success_timer: false,
  //has_changes_been_made: true,
  is_geting_key_auth: false,
  key_auth_err: "",
});

const returnKeyStatus = () => {
  return edit_key_data.form_data.key_status == 0
    ? key_status_arr[0]
    : edit_key_data.form_data.key_status == 1
    ? key_status_arr[1]
    : edit_key_data.form_data.key_status == 2
    ? key_status_arr[2]
    : "";
};
const updateSuccessCancelTimer = () => {
  edit_key_data.cancel_success_timer = true;
};

const removeFormErr = (input_name) => {
  if (input_name == "name") {
    edit_key_data.errors.name_err = "";
  }

  if (input_name == "desc") {
    edit_key_data.errors.desc_err = "";
  }

  if (input_name == "key_storage") {
    edit_key_data.errors.storage_err = "";
  }

  if (input_name == "comment") {
    edit_key_data.errors.comment_err = "";
  }

  if (input_name == "department" || input_name == "coworker") {
    edit_key_data.errors.department_or_coworker_err = "";
  }
};

const assignFormErr = (errorsArr) => {
  // console.log(errorsArr);
  errorsArr.forEach((error) => {
    if (error.toLowerCase().indexOf("name") > -1) {
      edit_key_data.errors.name_err = error;
    }

    if (error.toLowerCase().indexOf("description") > -1) {
      edit_key_data.errors.desc_err = error;
    }

    if (error.toLowerCase().indexOf("comment") > -1) {
      edit_key_data.errors.comment_err = error;
    }

    if (error.toLowerCase().indexOf("storage") > -1) {
      edit_key_data.errors.storage_err = error;
    }

    if (error.toLowerCase().indexOf("completed this section") > -1) {
      edit_key_data.errors.department_or_coworker_err = error;
    }
  });
};

const checkForFormErrors = () => {
  let abort = false,
    errors_arr = [];
  if (edit_key_data.form_data.name == "") {
    abort = true;
    errors_arr.push("The Key name or number field is required");
  }

  if (edit_key_data.form_data.description == "") {
    abort = true;
    errors_arr.push("The description field is required");
  }

  if (edit_key_data.form_data.key_storage_id === 0) {
    abort = true;
    errors_arr.push("Please select storage for the key");
  }

  if (
    edit_key_data.form_data.selected_department.length === 0 &&
    edit_key_data.form_data.selected_coworker.length === 0
  ) {
    // console.log(edit_key_data.form_data.selected_department.length);
    abort = true;
    errors_arr.push(
      "Please completed this section by selecting a department, co-workers or both"
    );
  }

  return {
    abort,
    errors_arr,
  };
};

const handleAddKeyForm = () => {
  let err_check = checkForFormErrors();

  if (err_check.abort) {
    assignFormErr(err_check.errors_arr);
  } else {
    scrollToTopOrBottomOfPage();
    edit_key_data.is_form_processing = true;
    setTimeout(async () => {
      try {
        edit_key_data.cancel_success_timer = false;
        const res = await axios.post("/keys/handle-update-key", edit_key_data.form_data);
        if (res?.data?.errors.length > 0) {
          assignFormErr(res?.data?.errors);
        } else {
          //success
          edit_key_data.custom_success = `Thanks,  key ${edit_key_data.form_data.name} has been updated successfully`;
          setTimeout(() => {
            if (!edit_key_data.cancel_success_timer) {
              router.get("/");
            }
          }, 10000);
        }
      } catch (err) {
        //console.log(err);
        edit_key_data.custom_err = returnSystemErrorMsg();
      } finally {
        edit_key_data.is_form_processing = false;
      }
    }, 300);
  } // end if err_check abort
};

const updateSelectedKeyStorage = (selected_storage) => {
  edit_key_data.form_data.key_storage_id = selected_storage.id;
  edit_key_data.form_data.key_storage_name = selected_storage.name;
};

const updateSelectedDepartment = (result_obj) => {
  if (result_obj.action == "push") {
    edit_key_data.form_data.selected_department.push(result_obj.value);
  } else {
    edit_key_data.form_data.selected_department = result_obj.value;
  }

  if (edit_key_data.errors.department_or_coworker_err != "") {
    edit_key_data.errors.department_or_coworker_err = "";
  }
  // console.log(edit_key_data.form_data.selected_department.length);
};

const updateSelectedCoworker = (result_obj) => {
  if (result_obj.action == "push") {
    edit_key_data.form_data.selected_coworker.push(result_obj.value);
  } else {
    edit_key_data.form_data.selected_coworker = result_obj.value;
  }

  if (edit_key_data.errors.department_or_coworker_err != "") {
    edit_key_data.errors.department_or_coworker_err = "";
  }
};

const handleStatusChange = (new_status) => {
  if (new_status == key_status_arr[0]) {
    edit_key_data.form_data.key_status = 0;
  } else if (new_status == key_status_arr[1]) {
    edit_key_data.form_data.key_status = 1;
  } else if (new_status == key_status_arr[2]) {
    edit_key_data.form_data.key_status = 2;
  }
};

onMounted(() => {
  focusOnFirstInput(firstInput);
});
</script>
