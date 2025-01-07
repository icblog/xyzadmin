<template>
  <Layout pageTitle="add-coworker" pageIntro="Add co-worker">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="0" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="form-wrapper">
              <section v-show="registerFormData.isRegisterFormProcessing">
                <LoadingIndicator />
              </section>
              <section v-if="!registerFormData.isRegisterFormProcessing">
                <HandleMsg
                  v-if="registerFormData.customErr != ''"
                  infotype="error"
                  :msg="registerFormData.customErr"
                  customClass="form-responds-msg"
                />

                <div v-else-if="registerFormData.customSuccess != ''">
                  <HandleMsg
                    infotype="success"
                    :msg="registerFormData.customSuccess"
                    customClass="form-responds-msg"
                  />

                  <AfterSuccessBtn
                    add_link_name="/user/add-coworker"
                    redirect_link_name="/view-users"
                    click_action_add="add_another"
                    click_action_redirect="view_users"
                    add_btn_name="Add another co-worker"
                    redirect_btn_name="View co-workers"
                    @updateSuccessCancelTimer="updateSuccessCancelTimer"
                  />
                </div>

                <HandleMsg
                  v-else-if="registerFormData.customSuccess != ''"
                  infotype="success"
                  :msg="registerFormData.customSuccess"
                  customClass="form-responds-msg"
                />

                <form v-else @submit.prevent="handleRegisterForm">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label" for="first_name">First name*</label>
                        <div
                          class="text-danger small"
                          v-show="registerFormData.errors.first_name != ''"
                        >
                          {{ registerFormData.errors.first_name }}
                        </div>
                        <input
                          ref="firstInput"
                          v-model="registerFormData.formData.first_name"
                          type="text"
                          class="form-control"
                          id="first_name"
                          name="first_name"
                          maxlength="255"
                          autocomplete="off"
                          @focus="() => removeRegisterFormError('first_name')"
                        />
                      </div>
                      <!-- end col-md-6 -->
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label" for="last_name">Last name*</label>
                        <div
                          class="text-danger small"
                          v-show="registerFormData.errors.last_name != ''"
                        >
                          {{ registerFormData.errors.last_name }}
                        </div>
                        <input
                          v-model="registerFormData.formData.last_name"
                          type="text"
                          class="form-control"
                          id="last_name"
                          name="last_name"
                          maxlength="255"
                          autocomplete="off"
                          @focus="() => removeRegisterFormError('last_name')"
                        />
                      </div>

                      <!-- end col-md-6 -->
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label" for="email">Email*</label>
                        <div
                          class="text-danger small"
                          v-show="registerFormData.errors.email != ''"
                        >
                          {{ registerFormData.errors.email }}
                        </div>
                        <input
                          v-model="registerFormData.formData.email"
                          type="text"
                          class="form-control"
                          id="email"
                          name="email"
                          maxlength="255"
                          autocomplete="off"
                          @focus="() => removeRegisterFormError('email')"
                        />
                      </div>

                      <!-- end col-md-6 -->
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label" for="phone">Phone*</label>
                        <div
                          class="text-danger small"
                          v-show="registerFormData.errors.phone != ''"
                        >
                          {{ registerFormData.errors.phone }}
                        </div>
                        <input
                          v-model="registerFormData.formData.phone"
                          type="text"
                          class="form-control"
                          id="phone"
                          name="phone"
                          maxlength="11"
                          autocomplete="off"
                          @focus="() => removeRegisterFormError('phone')"
                        />
                      </div>
                      <!-- end col-md-6 -->
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <OptionElementInput
                          v-if="departmentRes.length > 0"
                          whatToget="id"
                          labelName="Department*"
                          itemToHide="All department"
                          :inputErrMsg="registerFormData.errors.department"
                          :defaultOptionSelected="
                            registerFormData.optionSelectedNameValue
                          "
                          :disabledInput="true"
                          :resultObj="departmentRes"
                          :inputFocusFunc="() => removeRegisterFormError('department')"
                          @updateSelectedOptionInput="updateDepartmentSelected"
                        />
                      </div>
                      <!-- end col-md-12 -->
                    </div>

                    <!-- end row -->
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label pr-3"
                          >Give user access to ic-admin app?*</label
                        >
                        <div
                          v-show="registerFormData.errors.xyz_app_access_err != ''"
                          class="small text-danger p-0 m-0"
                        >
                          {{ registerFormData.errors.xyz_app_access_err }}
                        </div>
                        <div class="pl-5 ml-3">
                          <div class="form-check-inline">
                            <span class="form-check-label">
                              <input
                                type="radio"
                                class="form-check-input"
                                id="no"
                                :value="0"
                                v-model="registerFormData.formData.xyz_app_access"
                                @click="() => removeRegisterFormError('xyz_app_access')"
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
                                v-model="registerFormData.formData.xyz_app_access"
                                @click="() => removeRegisterFormError('xyz_app_access')"
                              />Yes
                            </span>
                          </div>
                        </div>
                      </div>
                      <!-- end col-md-6 -->
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label pr-3">Is user a leader?*</label>
                        <div
                          v-show="registerFormData.errors.leader_err != ''"
                          class="small text-danger p-0 m-0"
                        >
                          {{ registerFormData.errors.leader_err }}
                        </div>
                        <div class="pl-5 ml-3">
                          <div class="form-check-inline">
                            <span class="form-check-label">
                              <input
                                type="radio"
                                class="form-check-input"
                                id="no"
                                :value="0"
                                v-model="registerFormData.formData.leader"
                                @click="() => removeRegisterFormError('leader')"
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
                                v-model="registerFormData.formData.leader"
                                @click="() => removeRegisterFormError('leader')"
                              />Yes
                            </span>
                          </div>
                        </div>
                      </div>
                      <!-- end col-md-6 -->
                    </div>
                    <!-- end row -->
                  </div>

                  <!-- To detect bot -->
                  <input
                    v-model="registerFormData.formData.myhouse"
                    type="text"
                    maxlength="2"
                    name="myhouse"
                    class="not_in_my_house"
                  />
                  <p class="small">All fields marked with a * are mandatory</p>
                  <div class="pt-3 row">
                    <div class="col-md-6 mx-auto">
                      <AppButton :fullBtn="true" btnType="submit" btnStyle="primary"
                        >Submit</AppButton
                      >
                    </div>
                  </div>
                </form>
              </section>
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
import LoadingIndicator from "../../shared/LoadingIndicator";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import AfterSuccessBtn from "../../shared/AfterSuccessBtn";
import OptionElementInput from "../../shared/OptionElementInput";
import SideBar from "../../shared/SideBar";
import Layout from "../../shared/Layout";
import {
  focusOnFirstInput,
  returnSystemErrorMsg,
  validMobileNumber,
  validateEmail,
  scrollToTopOrBottomOfPage,
} from "../../helper/util";
import axios from "../../api/axios";

let firstInput = ref(null);

const props = defineProps({
  errors: Object,
  departmentRes: {},
});

const registerFormData = reactive({
  formData: {
    first_name: "",
    last_name: "",
    email: "",
    phone: "",
    departmentSelectedId: "",
    xyz_app_access: "",
    leader: "",
    user_type: "coworker",
    myhouse: "",
  },
  errors: {
    first_name: "",
    last_name: "",
    email: "",
    phone: "",
    department: "",
    xyz_app_access_err: "",
    leader_err: "",
  },
  customErr: "",
  customSuccess: "",
  isRegisterFormProcessing: false,
  optionSelectedNameValue: "Select....",
  cancel_success_timer: false,
});

const updateSuccessCancelTimer = () => {
  registerFormData.cancel_success_timer = true;
};

const updateDepartmentSelected = (selectedDepartment) => {
  registerFormData.formData.departmentSelectedId = selectedDepartment.id;
  registerFormData.optionSelectedNameValue = selectedDepartment.name;
};

const removeRegisterFormError = (focusedInput) => {
  if (focusedInput == "first_name") {
    if (registerFormData.errors.first_name != "") {
      registerFormData.errors.first_name = "";
    }
  }

  if (focusedInput == "last_name") {
    if (registerFormData.errors.last_name != "") {
      registerFormData.errors.last_name = "";
    }
  }
  if (focusedInput == "email") {
    if (registerFormData.errors.email != "") {
      registerFormData.errors.email = "";
    }
  }
  if (focusedInput == "phone") {
    if (registerFormData.errors.phone != "") {
      registerFormData.errors.phone = "";
    }
  }

  if (focusedInput == "department") {
    if (registerFormData.errors.department != "") {
      registerFormData.errors.department = "";
    }
  }

  if (focusedInput == "xyz_app_access") {
    if (registerFormData.errors.xyz_app_access_err != "") {
      registerFormData.errors.xyz_app_access_err = "";
    }
  }

  if (focusedInput == "leader") {
    if (registerFormData.errors.leader_err != "") {
      registerFormData.errors.leader_err = "";
    }
  }
};

const assignRegisterFormErrorMsg = (errorsArr) => {
  // console.log(errorsArr);
  errorsArr.forEach((error) => {
    if (error.toLowerCase().indexOf("first name") > -1) {
      registerFormData.errors.first_name = error;
    }
    if (error.toLowerCase().indexOf("last name") > -1) {
      registerFormData.errors.last_name = error;
    }
    if (error.toLowerCase().indexOf("email") > -1) {
      registerFormData.errors.email = error;
    }
    if (error.toLowerCase().indexOf("phone") > -1) {
      registerFormData.errors.phone = error;
    }
    if (error.toLowerCase().indexOf("department") > -1) {
      registerFormData.errors.department = error;
    }
    if (error.toLowerCase().indexOf("access to xyz app") > -1) {
      registerFormData.errors.xyz_app_access_err = error;
    }
    if (error.toLowerCase().indexOf("leader") > -1) {
      registerFormData.errors.leader_err = error;
    }
  });
};

const checkForRegisterFormErrors = () => {
  let abort = false,
    errorsArr = [];
  if (registerFormData.formData.first_name === "") {
    abort = true;
    errorsArr.push("The first name field is required");
  }
  if (registerFormData.formData.last_name === "") {
    abort = true;
    errorsArr.push("The last name field is required");
  }
  if (registerFormData.formData.email === "") {
    abort = true;
    errorsArr.push("The email field is required");
  }

  if (registerFormData.formData.email != "") {
    if (!validateEmail(registerFormData.formData.email)) {
      abort = true;
      errorsArr.push("The email is invalid");
    }
  }

  if (registerFormData.formData.phone === "") {
    abort = true;
    errorsArr.push("The phone field is required");
  }

  if (registerFormData.formData.phone != "") {
    if (!validMobileNumber(registerFormData.formData.phone)) {
      abort = true;
      errorsArr.push("The phone number is invalid");
    }
  }

  if (registerFormData.formData.departmentSelectedId === "") {
    abort = true;
    errorsArr.push("Please select a department");
  }

  if (registerFormData.formData.xyz_app_access === "") {
    abort = true;
    errorsArr.push("Please indicate if user should have access to xyz app");
  }

  if (registerFormData.formData.leader === "") {
    abort = true;
    errorsArr.push("Please indicate if user is a leader");
  }

  return {
    abort,
    errorsArr,
  };
};

const handleRegisterForm = async () => {
  const errorsCheck = checkForRegisterFormErrors();

  if (errorsCheck.abort) {
    assignRegisterFormErrorMsg(errorsCheck.errorsArr);
  } else {
    try {
      registerFormData.cancel_success_timer = false;
      registerFormData.isRegisterFormProcessing = true;
      scrollToTopOrBottomOfPage();
      const res = await axios.post("/handle-add-user", registerFormData.formData);
      if (res?.data?.errors.length > 0) {
        assignRegisterFormErrorMsg(res?.data?.errors);
      } else {
        //success
        registerFormData.customSuccess =
          "Thanks, email instruction has been sent to the user.";
        setTimeout(() => {
          if (!registerFormData.cancel_success_timer) {
            router.get("/");
          }
        }, 8000);
      }
    } catch (err) {
      //console.log(err);
      registerFormData.customErr = returnSystemErrorMsg();
    } finally {
      registerFormData.isRegisterFormProcessing = false;
    }
  } //end errorsCheck.abort
};

onMounted(() => {
  //fetchDepartments();
  focusOnFirstInput(firstInput);
});
</script>
