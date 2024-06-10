<template>
  <Layout pageTitle="add-department-company" pageIntro="Add department or company">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="4" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="form-wrapper">
              <section v-if="depart_comp_data.is_form_processing">
                <LoadingIndicator />
              </section>
              <section v-else>
                <form @submit.prevent="handleAddDepartOrCompForm">
                  <HandleMsg
                    v-if="depart_comp_data.add_error != ''"
                    infotype="error"
                    :msg="depart_comp_data.add_error"
                    customClass="form-responds-msg"
                  />
                  <div v-else-if="depart_comp_data.add_success != ''">
                  <HandleMsg
                    infotype="success"
                    :msg="depart_comp_data.add_success"
                    customClass="form-responds-msg"
                  />
                  <AfterSuccessBtn
                    add_link_name="/departcomp/add"
                    redirect_link_name="/view-all-depart-comp"
                    click_action_add="add_depart_comp"
                    click_action_redirect="view_depart_comp"
                    add_btn_name="Add another deprtment/company"
                    redirect_btn_name="View deprtment/company"
                    @updateSuccessCancelTimer="updateSuccessCancelTimer"
                  />
                </div>

                  <div v-else>
                    <p class="small pb-3">
                      Provide department or company name, indicate either department or company, add at least one phone contact. You can
                      later add more phone contact by going to the phones option in the menu to
                      the left of most pages.
                      <hr/>
                    </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="name"
                            >Department/Company name*</label
                          >
                          <div
                            v-show="depart_comp_data.errors.name_err != ''"
                            class="small text-danger p-0 m-0"
                          >
                            {{ depart_comp_data.errors.name_err }}
                          </div>
                          <input
                            ref="firstInput"
                            type="text"
                            id="name"
                            v-model="depart_comp_data.form_data.name"
                            class="form-control"
                            maxlength="255"
                            @focus="() => removeAddDepartOrCompFormErr('name')"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div>
                          <label class="form-label" for="name"
                            >Is this a department or company?*</label
                          >
                          <div
                            v-show="depart_comp_data.errors.is_company_err != ''"
                            class="small text-danger p-0 m-0"
                          >
                            {{ depart_comp_data.errors.is_company_err }}
                          </div>
                          <div class="pb-2">
                            <div class="form-check-inline">
                              <span class="form-check-label">
                                <input
                                  type="radio"
                                  class="form-check-input"
                                  id="no"
                                  :value="0"
                                  v-model="depart_comp_data.form_data.is_company"
                                  @click="
                                    () => removeAddDepartOrCompFormErr('is_company')
                                  "
                                />Department
                              </span>
                            </div>
                            <div class="form-check-inline">
                              <span class="form-check-label">
                                <input
                                  type="radio"
                                  class="form-check-input"
                                  id="yes"
                                  :value="1"
                                  v-model="depart_comp_data.form_data.is_company"
                                  @click="
                                    () => removeAddDepartOrCompFormErr('is_company')
                                  "
                                />Company
                              </span>
                            </div>
                          </div>
                        </div>
                        <div v-show="depart_comp_data.form_data.is_company == 1">
                          <label class="form-label" for="name"
                            >Make it a quick company?*</label
                          >
                          <div
                            v-show="depart_comp_data.errors.is_quick_company_err != ''"
                            class="small text-danger p-0 m-0"
                          >
                            {{ depart_comp_data.errors.is_quick_company_err }}
                          </div>
                          <div class="pb-2">
                            <div class="form-check-inline">
                              <span class="form-check-label">
                                <input
                                  type="radio"
                                  class="form-check-input"
                                  id="no"
                                  :value="0"
                                  v-model="depart_comp_data.form_data.is_quick_company"
                                  @click="
                                    () => removeAddDepartOrCompFormErr('is_quick_company')
                                  "
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
                                  v-model="depart_comp_data.form_data.is_quick_company"
                                  @click="
                                    () => removeAddDepartOrCompFormErr('is_quick_company')
                                  "
                                />Yes
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- end row -->
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="name"
                            >Phone description/name*</label
                          >
                          <div
                            v-show="depart_comp_data.errors.desc_err != ''"
                            class="small text-danger pt-0 pb-0"
                          >
                            {{ depart_comp_data.errors.desc_err }}
                          </div>
                          <input
                            v-model="depart_comp_data.form_data.desc"
                            type="text"
                            class="form-control"
                            maxlength="255"
                            @focus="() => removeAddDepartOrCompFormErr('desc')"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label" for="name"
                            >Phone number/extension*</label
                          >
                          <div
                            v-show="depart_comp_data.errors.phone_err != ''"
                            class="small text-danger pt-0 pb-0"
                          >
                            {{ depart_comp_data.errors.phone_err }}
                          </div>
                          <input
                            v-model="depart_comp_data.form_data.phone"
                            type="text"
                            class="form-control"
                            maxlength="50"
                            @focus="() => removeAddDepartOrCompFormErr('phone')"
                          />
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                  <label class="form-label" for="email">Email
                  <span class="optional"
                                >(Optional)</span
                              ></label>
                  <div
                    class="text-danger small"
                    v-show="depart_comp_data.errors.email_err != ''"
                  >
                    {{ depart_comp_data.errors.email_err }}
                  </div>
                  <input
                    v-model="depart_comp_data.form_data.email"
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    maxlength="255"
                    autocomplete="off"
                    @focus="() => removeAddDepartOrCompFormErr('email')"
                  />
                </div>
                 </div>
                      <!-- end row -->
                    </div>

                    <p class="small pt-3">
                      Please note, all fields marked with a * are mandatory
                    </p>
                    <div class="pt-3 row">
                      <div class="col-md-6 mx-auto">
                        <AppButton btnType="submit" btnStyle="primary">Submit</AppButton>
                      </div>
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
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import AfterSuccessBtn from "../../shared/AfterSuccessBtn";
import LoadingIndicator from "../../shared/LoadingIndicator";
import {
  focusOnFirstInput,
  returnSystemErrorMsg,
  scrollToTopOrBottomOfPage,
  validateEmail
} from "../../helper/util";
import axios from "../../api/axios";

const firstInput = ref(null);

const props = defineProps({
  errors: Object,
});

const depart_comp_data = reactive({
  form_data: {
    name: "",
    is_company: "",
    is_quick_company: "",
    desc: "",
    phone: "",
    email: "",
  },
  errors: {
    name_err: "",
    is_company_err: "",
    is_quick_company_err: "",
    desc_err: "",
    phone_err: "",
    email_err: "",
  },
  is_form_processing: false,
  add_success: "",
  add_error: "",
  cancel_success_timer: false,
});

const updateSuccessCancelTimer = () => {
  depart_comp_data.cancel_success_timer = true;
};

const removeAddDepartOrCompFormErr = (input_name) => {
  if (input_name == "name" && depart_comp_data.errors.name_err != "") {
    depart_comp_data.errors.name_err = "";
  }

  if (input_name == "desc" && depart_comp_data.errors.desc_err != "") {
    depart_comp_data.errors.desc_err = "";
  }

  if (input_name == "phone" && depart_comp_data.errors.phone_err != "") {
    depart_comp_data.errors.phone_err = "";
  }

  if (input_name == "is_company" && depart_comp_data.errors.is_company_err != "") {
    depart_comp_data.errors.is_company_err = "";
  }

  if (
    input_name == "is_quick_company" &&
    depart_comp_data.errors.is_quick_company_err != ""
  ) {
    depart_comp_data.errors.is_quick_company_err = "";
  }

  if (input_name == "email" && depart_comp_data.errors.email_err!= "") {
    depart_comp_data.errors.email_err = "";
  }


};

const assignAddDepartOrCompFormErr = (errorsArr) => {
  // console.log(errorsArr);
  errorsArr.forEach((error) => {
    if (error.toLowerCase().indexOf("department or company name") > -1) {
      depart_comp_data.errors.name_err = error;
    }
    if (error.toLowerCase().indexOf("description") > -1) {
      depart_comp_data.errors.desc_err = error;
    }

    if (error.toLowerCase().indexOf("number or extension") > -1) {
      depart_comp_data.errors.phone_err = error;
    }

    if (error.toLowerCase().indexOf("indicate if department or company") > -1) {
      depart_comp_data.errors.is_company_err = error;
    }
    if (error.toLowerCase().indexOf("make it a quick company") > -1) {
      depart_comp_data.errors.is_quick_company_err = error;
    }
    if (error.toLowerCase().indexOf("email") > -1) {
      depart_comp_data.errors.email_err = error;
    }
  });
};

const checkForAddDepartOrCompFormErrors = () => {
  let abort = false,
    errors_arr = [];
  if (depart_comp_data.form_data.name == "") {
    abort = true;
    errors_arr.push("The department or company name field is required");
  }

  if (depart_comp_data.form_data.desc == "") {
    abort = true;
    errors_arr.push("Please ensure the phone description is filled in");
  }

  if (depart_comp_data.form_data.phone == "") {
    abort = true;
    errors_arr.push("Number or extension is required");
  }

  if (depart_comp_data.form_data.is_company === "") {
    
    abort = true;
    errors_arr.push("Please indicate if department or company");
  }

  if (depart_comp_data.form_data.is_company === 1) {
    if (depart_comp_data.form_data.is_quick_company === "") {
      abort = true;
      errors_arr.push("Please indicate if to make it a quick company");
    }
  }

  if (depart_comp_data.form_data.email != '') {
    if (!validateEmail(depart_comp_data.form_data.email)) {
      abort = true;
      errors_arr.push("The email is invalid");
    }
   
  }

  return {
    abort,
    errors_arr,
  };
};

const handleAddDepartOrCompForm = async () => {
  const err_check = checkForAddDepartOrCompFormErrors();

  if (err_check.abort) {
    assignAddDepartOrCompFormErr(err_check.errors_arr);
  } else {
    //submit the form if no errors

    try {
      depart_comp_data.is_form_processing = true;
      depart_comp_data.cancel_success_timer = false;
      scrollToTopOrBottomOfPage();
      const res = await axios.post("/handle-add-depart-comp", depart_comp_data.form_data);
      if (res?.data?.errors.length > 0) {
        assignAddDepartOrCompFormErr(res?.data?.errors);
      } else {
        //success
        depart_comp_data.add_success =
          "Thanks, department or company has been added successfully";
          setTimeout(() => {
          if (!depart_comp_data.cancel_success_timer) {
            router.get("/");
          }
        }, 10000);
       
      }
    } catch (err) {
      //console.log(err);
      depart_comp_data.add_error = returnSystemErrorMsg();
    } finally {
      depart_comp_data.is_form_processing = false;
    }
  }
};

onMounted(() => {
  focusOnFirstInput(firstInput);
});
</script>
