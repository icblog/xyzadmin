<template>
  <Layout pageTitle="add-key" pageIntro="Add key">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="6" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="form-wrapper">
              <section v-if="add_key_data.is_form_processing">
                <LoadingIndicator />
              </section>

              <section v-else>
                <form @submit.prevent="handleAddKeyForm">
                  <HandleMsg
                    v-if="add_key_data.custom_err != ''"
                    infotype="error"
                    :msg="add_key_data.custom_err"
                    customClass="form-responds-msg"
                  />
                  <div v-else-if="add_key_data.custom_success != ''">
                    <HandleMsg
                      infotype="success"
                      :msg="add_key_data.custom_success"
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
                            v-show="add_key_data.errors.name_err != ''"
                            class="small text-danger p-0 m-0"
                          >
                            {{ add_key_data.errors.name_err }}
                          </div>
                          <input
                            ref="firstInput"
                            type="text"
                            id="name"
                            v-model="add_key_data.form_data.name"
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
                            v-show="add_key_data.errors.desc_err != ''"
                            class="small text-danger p-0 m-0"
                          >
                            {{ add_key_data.errors.desc_err }}
                          </div>
                          <textarea
                            v-model="add_key_data.form_data.description"
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
                          <OptionElementInput
                            v-if="add_key_data.key_storage_obj.length > 0"
                            labelName="Select a storage for the key*"
                            :defaultOptionSelected="add_key_data.key_storage_name"
                            :resultObj="add_key_data.key_storage_obj"
                            :inputErrMsg="add_key_data.errors.storage_err"
                            :disabledInput="true"
                            whatToget="id"
                            :inputFocusFunc="() => removeFormErr('key_storage')"
                            @updateSelectedOptionInput="updateSelectedKeyStorage"
                          />
                        </div>
                        <!-- end div col md 6 -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label"
                            >Comment
                            <span class="optional">(Optional)</span>
                          </label>
                          <div
                            v-show="add_key_data.errors.comment_err != ''"
                            class="small text-danger p-0 m-0"
                          >
                            {{ add_key_data.errors.comment_err }}
                          </div>
                          <textarea
                            v-model="add_key_data.form_data.comment"
                            class="form-control"
                            rows="1"
                            cols="10"
                            @focus="() => removeFormErr('comment')"
                          ></textarea>
                        </div>
                        <!-- end div col md 6 -->
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
                      v-show="add_key_data.errors.department_or_coworker_err"
                      class="small text-danger p-0 m-0"
                    >
                      {{ add_key_data.errors.department_or_coworker_err }}
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <!-- Multi Select componenet department-->
                        <MultiSelect
                          v-if="add_key_data.department_obj.length > 0"
                          labelName="Select department"
                          :disabledInput="true"
                          whatToget="id"
                          :resultObj="add_key_data.department_obj"
                          :defaultOptionSelected="
                            add_key_data.form_data.selected_department
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
                            add_key_data.form_data.selected_coworker
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
                    <div class="pt-3 row">
                      <div class="col-md-6 mx-auto">
                        <AppButton
                          btnType="submit"
                          :fullBtn="true"
                          customClass="primary-btn"
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

const props = defineProps({
  errors: Object,
  key_storage_res: {},
  department_res: {},
});

const add_key_data = reactive({
  form_data: {
    name: "",
    description: "",
    key_storage_id: 0,
    key_storage_name: "",
    comment: "",
    selected_department: [],
    selected_coworker: [],
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
  key_storage_name: "Select....",
  custom_err: "",
  custom_success: "",
  is_form_processing: false,
  cancel_success_timer: false,
});

const updateSuccessCancelTimer = () => {
  add_key_data.cancel_success_timer = true;
};

const removeFormErr = (input_name) => {
  if (input_name == "name") {
    add_key_data.errors.name_err = "";
  }

  if (input_name == "desc") {
    add_key_data.errors.desc_err = "";
  }

  if (input_name == "key_storage") {
    add_key_data.errors.storage_err = "";
  }

  if (input_name == "comment") {
    add_key_data.errors.comment_err = "";
  }

  if (input_name == "department" || input_name == "coworker") {
    add_key_data.errors.department_or_coworker_err = "";
  }
};

const assignFormErr = (errorsArr) => {
  // console.log(errorsArr);
  errorsArr.forEach((error) => {
    if (error.toLowerCase().indexOf("name") > -1) {
      add_key_data.errors.name_err = error;
    }

    if (error.toLowerCase().indexOf("description") > -1) {
      add_key_data.errors.desc_err = error;
    }

    if (error.toLowerCase().indexOf("comment") > -1) {
      add_key_data.errors.comment_err = error;
    }

    if (error.toLowerCase().indexOf("storage") > -1) {
      add_key_data.errors.storage_err = error;
    }

    if (error.toLowerCase().indexOf("completed this section") > -1) {
      add_key_data.errors.department_or_coworker_err = error;
    }
  });
};

const checkForFormErrors = () => {
  let abort = false,
    errors_arr = [];
  if (add_key_data.form_data.name == "") {
    abort = true;
    errors_arr.push("The Key name or number field is required");
  }

  if (add_key_data.form_data.description == "") {
    abort = true;
    errors_arr.push("The description field is required");
  }

  if (add_key_data.form_data.key_storage_id === 0) {
    abort = true;
    errors_arr.push("Please select storage for the key");
  }

  if (
    add_key_data.form_data.selected_department.length === 0 &&
    add_key_data.form_data.selected_coworker.length === 0
  ) {
    console.log(add_key_data.form_data.selected_department.length);
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

const handleAddKeyForm = async () => {
  let err_check = checkForFormErrors();

  if (err_check.abort) {
    assignFormErr(err_check.errors_arr);
  } else {
    try {
      scrollToTopOrBottomOfPage();
      add_key_data.is_form_processing = true;
      add_key_data.cancel_success_timer = false;
      const res = await axios.post("/keys/handle-add-key", add_key_data.form_data);
      if (res?.data?.errors.length > 0) {
        assignFormErr(res?.data?.errors);
      } else {
        //success
        add_key_data.custom_success = `Thanks,  key ${add_key_data.form_data.name} has been added successfully`;
        setTimeout(() => {
          if (!add_key_data.cancel_success_timer) {
            router.get("/");
          }
        }, 10000);
      }
    } catch (err) {
      //console.log(err);
      add_key_data.custom_err = returnSystemErrorMsg();
    } finally {
      add_key_data.is_form_processing = false;
    }
  } // end if err_check abort
};

const updateSelectedKeyStorage = (selected_storage) => {
  add_key_data.form_data.key_storage_id = selected_storage.id;
  add_key_data.form_data.key_storage_name = selected_storage.name;
};

const updateSelectedDepartment = (result_obj) => {
  if (result_obj.action == "push") {
    add_key_data.form_data.selected_department.push(result_obj.value);
  } else {
    add_key_data.form_data.selected_department = result_obj.value;
  }

  if (add_key_data.errors.department_or_coworker_err != "") {
    add_key_data.errors.department_or_coworker_err = "";
  }
  // console.log(add_key_data.form_data.selected_department.length);
};

const updateSelectedCoworker = (result_obj) => {
  if (result_obj.action == "push") {
    add_key_data.form_data.selected_coworker.push(result_obj.value);
  } else {
    add_key_data.form_data.selected_coworker = result_obj.value;
  }

  if (add_key_data.errors.department_or_coworker_err != "") {
    add_key_data.errors.department_or_coworker_err = "";
  }
};

onMounted(() => {
  focusOnFirstInput(firstInput);
});
</script>
