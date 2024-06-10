<template>
  <Layout pageTitle="add-phone" pageIntro="Add phone">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="3" />
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="form-wrapper">
              <section v-show="add_phone_data.is_add_phone_form_processing">
                <LoadingIndicator />
              </section>

              <section v-show="!add_phone_data.is_add_phone_form_processing">
                <HandleMsg
                  v-if="add_phone_data.custom_err != ''"
                  infotype="error"
                  :msg="add_phone_data.custom_err"
                  customClass="form-responds-msg"
                />
                <div v-else-if="add_phone_data.custom_success != ''">
                  <HandleMsg
                    infotype="success"
                    :msg="add_phone_data.custom_success"
                    customClass="form-responds-msg mb-4"
                  />

                  <AfterSuccessBtn
                    add_link_name="/phones/add"
                    redirect_link_name="/phones"
                    click_action_add="add_another"
                    click_action_redirect="view_phones"
                    add_btn_name="Add another phone"
                    redirect_btn_name="View phones"
                    @updateSuccessCancelTimer="updateSuccessCancelTimer"
                  />
                </div>

                <form v-else @submit.prevent="handleAddPhoneForm">
                  <p class="small">
                    Start by selecting department or company, enter name or description of
                    phone and a number. Click on the plus button to add more phone or
                    minus button to remove phone before saving thanks.
                  </p>
                  <div class="row">
                    <div class="col-md-12 pb-3">
                      <OptionElementInput
                        v-if="department_res.length > 0"
                        labelName="Department or Company*"
                        itemToHide="All department"
                        :inputErrMsg="add_phone_data.errors.department_err"
                        :defaultOptionSelected="
                          add_phone_data.formData.selected_department_name
                        "
                        whatToget="id"
                        :disabledInput="true"
                        :resultObj="department_res"
                        :inputFocusFunc="() => removeAddPhoneFormErr('department')"
                        @updateSelectedOptionInput="updateSelectedDepartment"
                      />
                    </div>
                    <div class="col-md-12">
                      <div
                        v-show="add_phone_data.errors.phone_desc != ''"
                        class="small text-danger"
                      >
                        {{ add_phone_data.errors.phone_desc }}
                      </div>
                      <div
                        v-for="(phone_desc, phone_desc_index) in add_phone_data.formData
                          .phone_desc"
                        class="row mb-3"
                      >
                        <div class="col">
                          <label class="form-label" for="name"
                            >Phone description/name*</label
                          >
                          <input
                            v-model="phone_desc.desc"
                            type="text"
                            class="form-control"
                            maxlength="50"
                            placeholder="Enter name or description"
                            @focus="() => removeAddPhoneFormErr('phone_desc')"
                          />
                        </div>

                        <div class="col">
                          <label class="form-label" for="name">Number/Extension*</label>
                          <div class="input-group">
                            <input
                              v-model="phone_desc.phone"
                              type="text"
                              maxlength="50"
                              class="form-control"
                              placeholder="Enter number"
                              @focus="() => removeAddPhoneFormErr('phone_desc')"
                            />

                            <div class="input-group-append">
                              <span class="ml-2 mr-2">
                                <AppButton
                                  btnType="button"
                                  customClass="btn-primary"
                                  :btnFunc="addField"
                                >
                                  <i class="fa fa-plus" aria-hidden="true"></i>
                                </AppButton>
                              </span>
                              <span
                                v-show="add_phone_data.formData.phone_desc.length > 1"
                              >
                                <AppButton
                                  btnType="button"
                                  customClass="btn-danger"
                                  :btnFunc="() => removeField(phone_desc_index)"
                                >
                                  <i class="fa fa-minus" aria-hidden="true"></i>
                                </AppButton>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 mx-auto pt-2">
                      <AppButton
                        :fullBtn="true"
                        btnType="submit"
                        customClass="primary-btn"
                      >
                        Save
                      </AppButton>
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
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import OptionElementInput from "../../shared/OptionElementInput";
import AfterSuccessBtn from "../../shared/AfterSuccessBtn";
import HandleMsg from "../../shared/HandleMsg";
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";
import AppButton from "../../shared/AppButton";
import LoadingIndicator from "../../shared/LoadingIndicator";
import { scrollToTopOrBottomOfPage } from "../../helper/util";

const default_placeholder = "Select...";

const props = defineProps({
  errors: Object,
  department_res: {},
  respondsMsg: "",
});

const add_phone_data = reactive({
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
  custom_err: "",
  is_add_phone_form_processing: false,
  custom_success: "",
  cancel_success_timer: false,
});

const updateSuccessCancelTimer = () => {
  add_phone_data.cancel_success_timer = true;
};

const removeAddPhoneFormErr = (input_name) => {
  if (input_name == "department") {
    add_phone_data.errors.department_err = "";
  }

  if (input_name == "phone_desc") {
    add_phone_data.errors.phone_desc = "";
  }
};

const updateSelectedDepartment = (res_obj) => {
  add_phone_data.formData.selected_department_id = res_obj.id;
  add_phone_data.formData.selected_department_name = res_obj.name;
};
const addField = () => {
  if (add_phone_data.formData.phone_desc.length <= 7) {
    add_phone_data.formData.phone_desc.push({ desc: "", phone: "" });
  }
};

const removeField = (index) => {
  add_phone_data.formData.phone_desc.splice(index, 1);
};

const assignAddPhoneFormErrors = (err_obj) => {
  if (err_obj?.selected_department_id !== undefined) {
    add_phone_data.errors.department_err = err_obj?.selected_department_id;
  }

  if (err_obj?.phone_desc_valid !== undefined) {
    add_phone_data.errors.phone_desc = err_obj?.phone_desc_valid;
  }
  if (err_obj?.fail !== undefined) {
    add_phone_data.custom_err = err_obj?.fail;
  }
};

const handleAddPhoneForm = () => {
  let abort = false;

  if (add_phone_data.formData.selected_department_name == default_placeholder) {
    abort = true;
    add_phone_data.errors.department_err = "Please select a department";
  }

  if (!abort) {
    add_phone_data.formData.phone_desc.forEach((phone) => {
      if (phone.desc == "" || phone.phone == "") {
        abort = true;
        add_phone_data.errors.phone_desc =
          "Please check you have filled in the decription and phone correctly";
        add_phone_data.formData.phone_desc_valid = "";
      } else {
        add_phone_data.formData.phone_desc_valid = "Yes";
      }
    });
  }

  if (!abort) {
    router.post("/phones/handle-add-phone-form", add_phone_data.formData, {
      onStart: () => {
        add_phone_data.is_add_phone_form_processing = true;
        scrollToTopOrBottomOfPage();
      },
      onFinish: () => {
        add_phone_data.is_add_phone_form_processing = false;

        if (props.respondsMsg == "code200") {
          add_phone_data.custom_success = `${add_phone_data.formData.phone_desc.length} ${
            add_phone_data.formData.phone_desc.length > 1 ? " phones" : " phone"
          } added sucessfully thank you`;

          setTimeout(() => {
            if (!add_phone_data.cancel_success_timer) {
              router.get("/");
            }
          }, 10000);
        }
      },
      onError: (errors) => {
        assignAddPhoneFormErrors(errors);
      },
    });
  } //end if abort is false
};
</script>
