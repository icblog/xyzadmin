<template>
  <Layout pageTitle="edit-phone" pageIntro="Edit phone">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="3" />
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="form-wrapper">
              <section v-if="edit_phone_data.custom_err != ''">
                <HandleMsg
                  infotype="error"
                  :msg="edit_phone_data.custom_err"
                  customClass="form-responds-msg"
                />
              </section>
              <section v-else>
                <div class="form-wrapper">
                  <p class="small">
                    Start by selecting department or company you wish to edit their phones
                  </p>
                  <div class="row">
                    <div class="col-md-12 pb-3">
                      <OptionElementInput
                        v-if="department_res.length > 0"
                        labelName="Department or Company*"
                        itemToHide="All department"
                        :inputErrMsg="edit_phone_data.errors.department_err"
                        :defaultOptionSelected="
                          edit_phone_data.formData.selected_department_name
                        "
                        whatToget="id"
                        :disabledInput="true"
                        :resultObj="department_res"
                        @updateSelectedOptionInput="handleSelectedDepartment"
                      />
                    </div>
                    <!-- end row -->
                  </div>

                  <div v-show="edit_phone_data.is_fetching_department_phones" class="row">
                    <div class="col-md-12 pb-3 pt-3">
                      <LoadingIndicator loaderSize="med" />
                    </div>
                    <!-- end row -->
                  </div>
                  <div
                    v-show="
                      !edit_phone_data.is_fetching_department_phones &&
                      edit_phone_data.department_phones_res.length > 0
                    "
                  >
                    <div
                      class="mb-3 mt-3"
                      v-for="(phone_desc, index) in edit_phone_data.department_phones_res"
                      :key="phone_desc.id"
                    >
                      <p
                        v-show="showErrMsgIfNotEmpty(phone_desc.id)"
                        class="small text-danger"
                      >
                        {{ edit_phone_data.phone_to_be_process_error }}
                      </p>
                      <div class="row">
                        <div class="col">
                          <input
                            ref="phone_desc_input_ref"
                            :value="
                              returnIfInputIsActive(phone_desc.id)
                                ? edit_phone_data.phone_to_be_process_desc_new_value
                                : phone_desc.description
                            "
                            :type="
                              returnIfInputIsActive(phone_desc.id) ? 'text' : 'button'
                            "
                            :class="{
                              'form-control': true,
                              'edit-phone-input': returnIfInputIsActive(phone_desc.id)
                                ? false
                                : true,
                            }"
                            @input="(e) => handlePhoneInputChange(e, 'desc')"
                            @focus="hideCustomErrorOnFocus"
                          />
                        </div>
                        -
                        <div class="col">
                          <div class="input-group">
                            <input
                              :value="
                                returnIfInputIsActive(phone_desc.id)
                                  ? edit_phone_data.phone_to_be_process_phone_new_value
                                  : phone_desc.phone
                              "
                              :type="
                                returnIfInputIsActive(phone_desc.id) ? 'text' : 'button'
                              "
                              :class="{
                                'form-control': true,
                                'edit-phone-input': returnIfInputIsActive(phone_desc.id)
                                  ? false
                                  : true,
                              }"
                              @input="(e) => handlePhoneInputChange(e, 'phone')"
                              @focus="hideCustomErrorOnFocus"
                            />
                            <!-- Start okay and cancel btn -->
                            <div
                              v-if="returnIfInputIsActive(phone_desc.id)"
                              class="input-group-append"
                            >
                              <span class="ml-2 mr-2">
                                <AppButton
                                  :btnStyle="
                                    returnIfPhoneIsEditing(phone_desc.id)
                                      ? 'secondary'
                                      : returnIfPhoneEditsuccess(phone_desc.id)
                                      ? 'success'
                                      : 'primary2'
                                  "
                                  :btnFunc="() => handleUpdatePhone(phone_desc.id, index)"
                                >
                                  <span v-if="returnIfPhoneIsEditing(phone_desc.id)">
                                    <LoadingIndicator
                                      loaderSize="small"
                                      :showBelowText="false"
                                    />
                                  </span>
                                  <span
                                    v-else-if="returnIfPhoneEditsuccess(phone_desc.id)"
                                  >
                                    {{ edit_phone_data.phone_to_be_process_success }}
                                  </span>
                                  <span v-else>
                                    <i class="fas fa-check"></i>
                                  </span>
                                </AppButton>
                                <!-- end edit btn -->
                              </span>
                              <span>
                                <AppButton
                                  btnStyle="warn"
                                  :hideBtn="hideCancelBtn(phone_desc.id)"
                                  :btnFunc="handleCancelBtn"
                                >
                                  <span><i class="fas fa-times"></i></span>
                                </AppButton>
                              </span>
                              <!-- End okay and cancel btn -->
                              <!-- end input-group-append -->
                            </div>
                            <!-- Start edit and delete btn -->
                            <div v-else class="input-group-append">
                              <span
                                :class="{
                                  'ml-2': true,
                                  'mr-2':
                                    edit_phone_data.department_phones_res.length > 1
                                      ? true
                                      : false,
                                }"
                              >
                                <AppButton
                                  customClass="btn-primary"
                                  :hideBtn="
                                    returnIfPhoneIsDeleting(phone_desc.id) ||
                                    returnIfPhoneIsDeletedSuccess(phone_desc.id)
                                  "
                                  :btnFunc="
                                    () =>
                                      handleEditBtn(
                                        index,
                                        phone_desc.id,
                                        phone_desc.phone,
                                        phone_desc.description
                                      )
                                  "
                                >
                                  <span><i class="fas fa-edit"></i></span>
                                </AppButton>
                              </span>
                              <!-- show delete btn if phone result is more than 1 -->
                              <span
                                v-show="edit_phone_data.department_phones_res.length > 1"
                              >
                                <AppButton
                                  :btnStyle="
                                    returnIfPhoneIsDeleting(phone_desc.id)
                                      ? 'secondary'
                                      : returnIfPhoneIsDeletedSuccess(phone_desc.id)
                                      ? 'success'
                                      : 'danger'
                                  "
                                  :btnFunc="
                                    () =>
                                      handleDeletePhone(
                                        phone_desc.id,
                                        phone_desc.description,
                                        phone_desc.phone
                                      )
                                  "
                                >
                                  <span v-if="returnIfPhoneIsDeleting(phone_desc.id)">
                                    <LoadingIndicator
                                      loaderSize="small"
                                      :showBelowText="false"
                                    />
                                  </span>
                                  <span
                                    v-else-if="
                                      returnIfPhoneIsDeletedSuccess(phone_desc.id)
                                    "
                                  >
                                    {{ edit_phone_data.phone_to_be_process_success }}
                                  </span>
                                  <span v-else>
                                    <i class="fas fa-trash"></i>
                                  </span>
                                </AppButton>
                              </span>
                              <!-- end edit and delete btn -->
                              <!-- end input-group-append -->
                            </div>
                            <!-- end input-group-->
                          </div>
                        </div>
                        <!-- end row -->
                      </div>
                      <div class="col-md-12">
                        <hr />
                      </div>
                    </div>
                  </div>
                  <!-- end form wrapper -->
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>
<script setup>
import { reactive, ref } from "vue";
import OptionElementInput from "../../shared/OptionElementInput";
import HandleMsg from "../../shared/HandleMsg";
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";
import AppButton from "../../shared/AppButton";
import LoadingIndicator from "../../shared/LoadingIndicator";
import { returnSystemErrorMsg, removeItemFromArrOrObjByValue } from "../../helper/util";
import axios from "../../api/axios";

const default_placeholder = "Select...";
let phone_desc_input_ref = ref(null);
const props = defineProps({
  errors: Object,
  department_res: {},
  respondsMsg: "",
});

const edit_phone_data = reactive({
  formData: {
    selected_department_id: "",
    selected_department_name: default_placeholder,
    phone_desc: [{ desc: "", phone: "" }],
    phone_desc_valid: "",
  },
  errors: {
    department_err: "",
    phone_desc: "",
  },
  department_res: props.department_res,
  department_phones_res: [],
  custom_err: "",
  custom_success: "",
  is_fetching_department_phones: false,
  is_fetching_department_phones_completed: false,

  //editing properties
  show_ok_cancel_btn: false,
  phone_to_be_process_id: "",
  phone_to_be_process_desc_new_value: "",
  phone_to_be_process_desc_old_value: "",
  phone_to_be_process_phone_new_value: "",
  phone_to_be_process_phone_old_value: "",
  phone_to_be_process_error: "",
  phone_to_be_process_success: "",
  phone_deleted: false,
  phone_deleting: false,
  phone_editing: false,
});

const hideCustomErrorOnFocus = () => {
  if (edit_phone_data.phone_to_be_process_error != "") {
    edit_phone_data.phone_to_be_process_error = "";
  }
};

const handlePhoneInputChange = (event, input_name) => {
  if (input_name == "desc") {
    edit_phone_data.phone_to_be_process_desc_new_value = event.target.value;
  } else if (input_name == "phone") {
    edit_phone_data.phone_to_be_process_phone_new_value = event.target.value;
  }
};

const showErrMsgIfNotEmpty = (phone_id) => {
  let is_empty_err_msg = false;
  if (
    edit_phone_data.phone_to_be_process_error != "" &&
    edit_phone_data.phone_to_be_process_id == phone_id
  ) {
    is_empty_err_msg = true;
  }
  return is_empty_err_msg;
};

const returnIfPhoneEditsuccess = (phone_id) => {
  let edited_success = false;
  if (
    edit_phone_data.phone_to_be_process_success != "" &&
    !edit_phone_data.phone_editing &&
    edit_phone_data.phone_to_be_process_id == phone_id
  ) {
    edited_success = true;
  }
  return edited_success;
};

const returnIfPhoneIsEditing = (phone_id) => {
  let is_editing = false;
  if (
    edit_phone_data.phone_editing &&
    edit_phone_data.phone_to_be_process_id == phone_id
  ) {
    is_editing = true;
  }
  return is_editing;
};

const returnIfPhoneIsDeleting = (phone_id) => {
  let phone_deleting = false;
  if (
    edit_phone_data.phone_deleting &&
    edit_phone_data.phone_to_be_process_id == phone_id
  ) {
    phone_deleting = true;
  }
  return phone_deleting;
};

const returnIfPhoneIsDeletedSuccess = (phone_id) => {
  let deleted_success = false;
  if (
    edit_phone_data.phone_deleted &&
    edit_phone_data.phone_to_be_process_success != "" &&
    edit_phone_data.phone_to_be_process_id == phone_id
  ) {
    deleted_success = true;
  }
  return deleted_success;
};

const handleCancelBtn = () => {
  edit_phone_data.phone_to_be_process_id = "";

  edit_phone_data.phone_to_be_process_phone_new_value = "";
  edit_phone_data.phone_to_be_process_phone_old_value = "";

  edit_phone_data.phone_to_be_process_desc_new_value = "";
  edit_phone_data.phone_to_be_process_desc_old_value = "";

  edit_phone_data.show_ok_cancel_btn = false;
  edit_phone_data.phone_to_be_process_success = "";

  edit_phone_data.phone_to_be_process_error = "";
  edit_phone_data.phone_deleted = false;
};

const hideCancelBtn = (phone_id) => {
  let is_success = false;
  if (
    edit_phone_data.phone_to_be_process_success != "" &&
    edit_phone_data.phone_to_be_process_id == phone_id
  ) {
    is_success = true;
  }
  return is_success;
};

const handleEditBtn = (index, phone_id, desc_value, phone_value) => {
  edit_phone_data.phone_to_be_process_id = phone_id;

  edit_phone_data.phone_to_be_process_phone_new_value = desc_value;
  edit_phone_data.phone_to_be_process_phone_old_value = desc_value;

  edit_phone_data.phone_to_be_process_desc_new_value = phone_value;
  edit_phone_data.phone_to_be_process_desc_old_value = phone_value;

  edit_phone_data.show_ok_cancel_btn = true;
  phone_desc_input_ref.value[index].focus();
};

const returnIfInputIsActive = (phone_id) => {
  let is_phone_edit_active = false;
  if (
    edit_phone_data.show_ok_cancel_btn &&
    edit_phone_data.phone_to_be_process_id == phone_id
  ) {
    is_phone_edit_active = true;
  }
  return is_phone_edit_active;
};

//HANDLE SELECTED DEPARTMENT
const handleSelectedDepartment = (res_obj) => {
  edit_phone_data.formData.selected_department_name = res_obj.name;
  //Fetch department phones
  edit_phone_data.is_fetching_department_phones = true;
  edit_phone_data.is_fetching_department_phones_completed = false;
  setTimeout(async () => {
    try {
      const res = await axios.post("/phones/fetch-department-phones", {
        department_id: res_obj.id,
      });
      if (res?.data?.error != "") {
        edit_phone_data.custom_err = res?.data?.error;
      } else {
        //success
        edit_phone_data.department_phones_res = res?.data?.department_phones_res;
      }
    } catch (err) {
      //console.log(err);
      edit_phone_data.custom_err = returnSystemErrorMsg();
    } finally {
      edit_phone_data.is_fetching_department_phones = false;
      edit_phone_data.is_fetching_department_phones_completed = true;
    }
  }, 300);
};

//HANDLE DELETE PHONE

const handleDeletePhone = (phone_id, phone_desc, phone_number) => {
  if (
    window.confirm(
      `Delete phone (${phone_desc} ${phone_number}) ? please note this can not be undone`
    )
  ) {
    edit_phone_data.phone_to_be_process_id = phone_id;
    edit_phone_data.phone_deleting = true;
    edit_phone_data.phone_deleted = false;

    setTimeout(async () => {
      try {
        const res = await axios.post("/phones/delete-phone", {
          phone_id: phone_id,
        });
        //res.data.outcome can be boolean or error message
        if (res?.data?.error == "") {
          //set success msg
          edit_phone_data.phone_to_be_process_success = "Success";
          edit_phone_data.phone_deleted = true;
          setTimeout(() => {
            handleCancelBtn();
            edit_phone_data.department_phones_res = removeItemFromArrOrObjByValue(
              phone_id,
              edit_phone_data.department_phones_res,
              "id",
              "obj"
            );
          }, 700);
        } else {
          //Set error meg
          edit_phone_data.phone_to_be_process_error = res?.data?.error;
          //console.log("PHONE ERROR =>", res.data.outcome);
        }
      } catch (err) {
        edit_phone_data.phone_to_be_process_error = returnSystemErrorMsg();
        //console.log("PHONE ERR =>", err);
      } finally {
        edit_phone_data.phone_deleting = false;
      }
    }, 1500);
  } //End window confirm
}; // end handleDeletePhone

//HANDLE UPDATE PHONE
const handleUpdatePhone = async (phone_id, index) => {
  let abort = false;
  if (
    edit_phone_data.phone_to_be_process_desc_new_value == "" ||
    edit_phone_data.phone_to_be_process_phone_new_value == ""
  ) {
    abort = true;
    edit_phone_data.phone_to_be_process_error =
      "Please fill in description or the phone number field.";
  }

  //check to ensure changes has been made.

  if (
    edit_phone_data.phone_to_be_process_desc_new_value ==
      edit_phone_data.phone_to_be_process_desc_old_value &&
    edit_phone_data.phone_to_be_process_phone_new_value ==
      edit_phone_data.phone_to_be_process_phone_old_value
  ) {
    abort = true;
    edit_phone_data.phone_to_be_process_error =
      "Please make a change before saving thank you";
  }

  if (!abort) {
    edit_phone_data.phone_editing = true;

    try {
      const res = await axios.post("/phones/update-phone", {
        phone_id: phone_id,
        desc_new_value: edit_phone_data.phone_to_be_process_desc_new_value,
        desc_old_value: edit_phone_data.phone_to_be_process_desc_old_value,
        phone_new_value: edit_phone_data.phone_to_be_process_phone_new_value,
        phone_old_value: edit_phone_data.phone_to_be_process_phone_old_value,
      });

      if (res?.data?.error == "") {
        //success
        edit_phone_data.phone_to_be_process_success = "Success";
        setTimeout(() => {
          edit_phone_data.phone_to_be_process_success = "";
          edit_phone_data.phone_to_be_process_id = "";
          edit_phone_data.department_phones_res[index].description =
            edit_phone_data.phone_to_be_process_desc_new_value;
          edit_phone_data.department_phones_res[index].phone =
            edit_phone_data.phone_to_be_process_phone_new_value;
        }, 700);
      } else {
        //Set error message
        edit_phone_data.phone_to_be_process_error = res?.data?.error;
      }
    } catch (err) {
      edit_phone_data.phone_to_be_process_error = returnSystemErrorMsg();
    } finally {
      edit_phone_data.phone_editing = false;
    }
  } //end if about is false
};
</script>
