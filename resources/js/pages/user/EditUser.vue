<template>
  <Layout pageTitle="edit-user" pageIntro="Edit user">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="0" />
            <!-- end col 3 -->
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="form-wrapper">
              <section v-show="editUserFormData.is_edit_form_processing">
                <LoadingIndicator />
              </section>
              <section v-show="!editUserFormData.is_edit_form_processing">
                <HandleMsg
                  v-if="editUserFormData.custom_err != ''"
                  infotype="error"
                  :msg="editUserFormData.custom_err"
                  customClass="form-responds-msg"
                />
                <div v-else-if="editUserFormData.custom_success != ''">
                  <HandleMsg
                    infotype="success"
                    :msg="editUserFormData.custom_success"
                    customClass="form-responds-msg"
                  />
                  <AfterSuccessBtn
                    add_link_name="/edit-user"
                    redirect_link_name="/view-users"
                    click_action_add="edit_another"
                    click_action_redirect="view_users"
                    add_btn_name="Edit another user"
                    redirect_btn_name="View users"
                    @updateSuccessCancelTimer="updateSuccessCancelTimer"
                  />
                </div>

                <form v-else @submit.prevent="handleEditFormSubmit">
                  <section v-if="editUserFormData.form_data.first_name == ''">
                    <p class="small">
                      Start typing the user first or last name you want to edit then click
                      on it.
                    </p>
                    <label class="form-label">First/Last name* </label>
                    <CoWorkerSearch
                      end_point="/find-user-edit"
                      :makeResultAlink="false"
                      resultFoundTextSingular="person"
                      resultFoundTextplural="people"
                      noResultText="Sorry no one found, try again thank you."
                      @updateSelected="updateSelectedCoworker"
                    />
                  </section>
                  <section v-else>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="first_name">First name*</label>
                          <div
                            class="text-danger small"
                            v-show="editUserFormData.errors.first_name != ''"
                          >
                            {{ editUserFormData.errors.first_name }}
                          </div>
                          <input
                            ref="firstInput"
                            v-model="editUserFormData.form_data.first_name"
                            type="text"
                            class="form-control"
                            id="first_name"
                            name="first_name"
                            maxlength="255"
                            autocomplete="off"
                            @focus="() => removeEditFormError('first_name')"
                          />
                        </div>
                        <!-- end col-md-6 -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="last_name">Last name*</label>
                          <div
                            class="text-danger small"
                            v-show="editUserFormData.errors.last_name != ''"
                          >
                            {{ editUserFormData.errors.last_name }}
                          </div>
                          <input
                            v-model="editUserFormData.form_data.last_name"
                            type="text"
                            class="form-control"
                            id="last_name"
                            name="last_name"
                            maxlength="255"
                            autocomplete="off"
                            @focus="() => removeEditFormError('last_name')"
                          />
                        </div>

                        <!-- end col-md-6 -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="email">Email*</label>
                          <div
                            class="text-danger small"
                            v-show="editUserFormData.errors.email != ''"
                          >
                            {{ editUserFormData.errors.email }}
                          </div>
                          <input
                            v-model="editUserFormData.form_data.email"
                            type="text"
                            class="form-control"
                            id="email"
                            name="email"
                            maxlength="255"
                            autocomplete="off"
                            @focus="() => removeEditFormError('email')"
                          />
                        </div>

                        <!-- end col-md-6 -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="phone">Phone*</label>
                          <div
                            class="text-danger small"
                            v-show="editUserFormData.errors.phone != ''"
                          >
                            {{ editUserFormData.errors.phone }}
                          </div>
                          <input
                            v-model="editUserFormData.form_data.phone"
                            type="text"
                            class="form-control"
                            id="phone"
                            name="phone"
                            maxlength="11"
                            autocomplete="off"
                            @focus="() => removeEditFormError('phone')"
                          />
                        </div>
                        <!-- end col-md-6 -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <OptionElementInput
                            v-if="departmentRes.length > 0"
                            whatToget="id"
                            labelName="Department*"
                            :inputErrMsg="editUserFormData.errors.department"
                            :defaultOptionSelected="
                              editUserFormData.option_selected_value
                            "
                            :disabledInput="true"
                            :resultObj="departmentRes"
                            :inputFocusFunc="() => removeEditFormError('department')"
                            @updateSelectedOptionInput="updateDepartmentSelected"
                          />
                        </div>
                        <!-- end col-md-6 -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label pr-3">Is user a leader?*</label>

                          <div class="pl-5 ml-3">
                            <div class="form-check-inline">
                              <span class="form-check-label">
                                <input
                                  type="radio"
                                  class="form-check-input"
                                  id="no"
                                  :value="0"
                                  :checked="
                                    editUserFormData.form_data.leader === 0 ? true : false
                                  "
                                  v-model="editUserFormData.form_data.leader"
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
                                  :checked="
                                    editUserFormData.form_data.leader === 1 ? true : false
                                  "
                                  v-model="editUserFormData.form_data.leader"
                                />Yes
                              </span>
                            </div>
                          </div>
                        </div>
                        <!-- end col-md-6 -->
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label pr-3"
                            >Give user access to ic-admin app?*</label
                          >
                          <div
                            v-show="editUserFormData.errors.xyz_app_access_err != ''"
                            class="small text-danger p-0 m-0"
                          >
                            {{ editUserFormData.errors.xyz_app_access_err }}
                          </div>
                          <div class="pl-5 ml-3">
                            <div class="form-check-inline">
                              <span class="form-check-label">
                                <input
                                  type="radio"
                                  class="form-check-input"
                                  id="no"
                                  :value="0"
                                  :checked="
                                    editUserFormData.form_data.xyz_app_access === 0
                                      ? true
                                      : false
                                  "
                                  v-model="editUserFormData.form_data.xyz_app_access"
                                  @click="() => removeEditFormError('xyz_app_access')"
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
                                  :checked="
                                    editUserFormData.form_data.xyz_app_access === 1
                                      ? true
                                      : false
                                  "
                                  v-model="editUserFormData.form_data.xyz_app_access"
                                  @click="() => removeEditFormError('xyz_app_access')"
                                />Yes
                              </span>
                            </div>
                          </div>
                        </div>
                        <!-- end col-md-6 -->
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label pr-3">Current role* </label>

                          <div class="pl-5 ml-3">
                            <div class="form-check-inline">
                              <span class="form-check-label">
                                <input
                                  type="radio"
                                  class="form-check-input"
                                  id="no"
                                  :value="0"
                                  :checked="
                                    editUserFormData.form_data.user_role === 0
                                      ? true
                                      : false
                                  "
                                  v-model="editUserFormData.form_data.user_role"
                                />User
                              </span>
                            </div>
                            <div class="form-check-inline">
                              <span class="form-check-label">
                                <input
                                  type="radio"
                                  class="form-check-input"
                                  id="yes"
                                  :value="1"
                                  :checked="
                                    editUserFormData.form_data.user_role === 1
                                      ? true
                                      : false
                                  "
                                  v-model="editUserFormData.form_data.user_role"
                                />Admin
                              </span>
                            </div>
                          </div>
                        </div>
                        <!-- end col-md-6 -->
                      </div>
                      <div class="col-md-12">
                        <p class="small">All fields marked with a * are mandatory</p>
                        <!-- end col-md-6 -->
                      </div>
                      <!-- end row -->
                    </div>

                    <!-- To detect bot -->
                    <input
                      v-model="editUserFormData.form_data.myhouse"
                      type="text"
                      maxlength="2"
                      name="myhouse"
                      class="not_in_my_house"
                    />

                    <div class="pt-3 row">
                      <div class="col-3">
                        <AppButton
                          :btnFunc="handleBackBtnClick"
                          customClass="change-selected-btn pt-2 pb-2 pl-5 pr-5"
                          >Back</AppButton
                        >
                      </div>
                      <div class="col-9">
                        <div class="text-right">
                          <AppButton
                            btnType="submit"
                            customClass="change-selected-btn pt-2 pb-2 pl-5 pr-5"
                            >Update</AppButton
                          >
                        </div>
                      </div>
                    </div>
                  </section>
                </form>
              </section>
              <!-- end form wrapper -->
            </div>
            <!-- end col 9 -->
          </div>
          <!-- end row -->
        </div>
      </div>
    </div>
  </Layout>
</template>
<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import LoadingIndicator from "../../shared/LoadingIndicator";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import AfterSuccessBtn from "../../shared/AfterSuccessBtn";
import OptionElementInput from "../../shared/OptionElementInput";
import SideBar from "../../shared/SideBar";
import CoWorkerSearch from "../../shared/CoWorkerSearch";
import Layout from "../../shared/Layout";
import {
  returnSystemErrorMsg,
  validMobileNumber,
  validateEmail,
  scrollToTopOrBottomOfPage,
} from "../../helper/util";
import axios from "../../api/axios";

const props = defineProps({
  errors: Object,
  departmentRes: {},
});

const editUserFormData = reactive({
  form_data: {
    user_id: 0,
    first_name: "",
    last_name: "",
    username: "",
    email: "",
    phone: "",
    department_selected_id: "",
    leader: "",
    old_app_access: "",
    xyz_app_access: "",
    user_role: "",
    old_email: "",
    myhouse: "",
  },
  errors: {
    first_name: "",
    last_name: "",
    email: "",
    phone: "",
    department: "",
    xyz_app_access_err: "",
  },
  custom_err: "",
  custom_success: "",
  is_edit_form_processing: false,
  option_selected_value: "Select....",
  cancel_success_timer: false,
});
const updateSuccessCancelTimer = () => {
  editUserFormData.cancel_success_timer = true;
};
const handleBackBtnClick = () => {
  scrollToTopOrBottomOfPage();
  setTimeout(() => {
    editUserFormData.form_data.first_name = "";
  }, 100);
};

const updateDepartmentSelected = (selected_department) => {
  editUserFormData.form_data.department_selected_id = selected_department.id;
  editUserFormData.option_selected_value = selected_department.name;
};

const removeEditFormError = (focusedInput) => {
  if (focusedInput == "first_name") {
    if (editUserFormData.errors.first_name != "") {
      editUserFormData.errors.first_name = "";
    }
  }

  if (focusedInput == "last_name") {
    if (editUserFormData.errors.last_name != "") {
      editUserFormData.errors.last_name = "";
    }
  }
  if (focusedInput == "email") {
    if (editUserFormData.errors.email != "") {
      editUserFormData.errors.email = "";
    }
  }
  if (focusedInput == "phone") {
    if (editUserFormData.errors.phone != "") {
      editUserFormData.errors.phone = "";
    }
  }
};

const assignEditUserFormErrorMsg = (errorsArr) => {
  // console.log(errorsArr);
  errorsArr.forEach((error) => {
    if (error.toLowerCase().indexOf("first name") > -1) {
      editUserFormData.errors.first_name = error;
    }
    if (error.toLowerCase().indexOf("last name") > -1) {
      editUserFormData.errors.last_name = error;
    }
    if (error.toLowerCase().indexOf("email") > -1) {
      editUserFormData.errors.email = error;
    }
    if (error.toLowerCase().indexOf("phone") > -1) {
      editUserFormData.errors.phone = error;
    }
  });
};

const checkForEditUserFormErrors = () => {
  let abort = false,
    errorsArr = [];
  if (editUserFormData.form_data.first_name === "") {
    abort = true;
    errorsArr.push("The first name field is required");
  }
  if (editUserFormData.form_data.last_name === "") {
    abort = true;
    errorsArr.push("The last name field is required");
  }
  if (editUserFormData.form_data.email === "") {
    abort = true;
    errorsArr.push("The email field is required");
  }

  if (editUserFormData.form_data.email != "") {
    if (!validateEmail(editUserFormData.form_data.email)) {
      abort = true;
      errorsArr.push("The email is invalid");
    }
  }

  if (editUserFormData.form_data.phone === "") {
    abort = true;
    errorsArr.push("The phone field is required");
  }

  if (editUserFormData.form_data.phone != "") {
    if (!validMobileNumber(editUserFormData.form_data.phone)) {
      abort = true;
      errorsArr.push("The phone number is invalid");
    }
  }
  return {
    abort,
    errorsArr,
  };
};

const updateSelectedCoworker = (selected_user) => {
  editUserFormData.form_data.user_id = selected_user.id;
  editUserFormData.form_data.first_name = selected_user.fname;
  editUserFormData.form_data.last_name = selected_user.lname;
  editUserFormData.form_data.username = selected_user.username;
  editUserFormData.form_data.email = selected_user.email;
  editUserFormData.form_data.old_email = selected_user.email;
  editUserFormData.form_data.phone = selected_user.phone;
  editUserFormData.form_data.department_selected_id = selected_user.department_id;
  editUserFormData.option_selected_value = selected_user.department_name;
  editUserFormData.form_data.leader = selected_user.is_leader;
  editUserFormData.form_data.xyz_app_access = selected_user.xyz_app_access;
  editUserFormData.form_data.old_app_access = selected_user.xyz_app_access;
  editUserFormData.form_data.user_role = selected_user.role;
};

const handleEditFormSubmit = async () => {
  const errorsCheck = checkForEditUserFormErrors();
  // const l = false;
  if (errorsCheck.abort) {
    assignEditUserFormErrorMsg(errorsCheck.errorsArr);
  } else {
    try {
      editUserFormData.cancel_success_timer = false;
      editUserFormData.is_edit_form_processing = true;
      scrollToTopOrBottomOfPage();
      const res = await axios.post("/update-user", editUserFormData.form_data);
      if (res?.data?.errors.length > 0) {
        assignEditUserFormErrorMsg(res?.data?.errors);
      } else {
        editUserFormData.custom_success = "User update successful, thank you.";
        setTimeout(() => {
          if (!editUserFormData.cancel_success_timer) {
            router.get("/");
          }
        }, 10000);
      }
    } catch (err) {
      //console.log(err);
      editUserFormData.custom_err = returnSystemErrorMsg();
    } finally {
      editUserFormData.is_edit_form_processing = false;
    }
  } // end if error
};
</script>
