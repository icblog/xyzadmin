<template>
  <div class="form-wrapper pt-2">
    <section v-if="edit_depart_comp_data.is_edit_form_processing">
      <LoadingIndicator />
    </section>
    <section v-else>
      <HandleMsg
        v-if="edit_depart_comp_data.edit_error != ''"
        infotype="error"
        :msg="edit_depart_comp_data.edit_error"
        customClass="form-responds-msg mt-4"
      />

      <HandleMsg
        v-else-if="edit_depart_comp_data.edit_success != ''"
        infotype="success"
        :msg="edit_depart_comp_data.edit_success"
        customClass="form-responds-msg mt-4"
      />
      <form v-else @submit.prevent="handleEditFormSubmit">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="name"
                >{{ depart_comp?.is_depart_or_comp === 0 ? "Department" : "Company" }}
                name*
              </label>
              <div
                v-show="edit_depart_comp_data.errors.name_err != ''"
                class="small text-danger p-0 m-0"
              >
                {{ edit_depart_comp_data.errors.name_err }}
              </div>
              <input
                type="text"
                id="name"
                v-model="edit_depart_comp_data.form_data.name"
                class="form-control"
                maxlength="255"
                @focus="() => removeEditDepartOrCompFormErr('name')"
              />
            </div>
          </div>
          <div class="col-md-6">
            <div>
              <label class="form-label" for="name"
                >Is this a department or company?*</label
              >
              <div
                v-show="edit_depart_comp_data.errors.is_company_err != ''"
                class="small text-danger p-0 m-0"
              >
                {{ edit_depart_comp_data.errors.is_company_err }}
              </div>
              <div class="pb-2">
                <div class="form-check-inline">
                  <span class="form-check-label">
                    <input
                      type="radio"
                      class="form-check-input"
                      id="no"
                      :value="0"
                      :checked="
                        edit_depart_comp_data.form_data.is_company === 0 ? true : false
                      "
                      v-model="edit_depart_comp_data.form_data.is_company"
                      @click="() => removeEditDepartOrCompFormErr('is_company')"
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
                      :checked="
                        edit_depart_comp_data.form_data.is_company === 1 ? true : false
                      "
                      v-model="edit_depart_comp_data.form_data.is_company"
                      @click="() => removeEditDepartOrCompFormErr('is_company')"
                    />Company
                  </span>
                </div>
              </div>
            </div>
            <div v-show="edit_depart_comp_data.form_data.is_company === 1">
              <label class="form-label" for="name">Make it a quick company?*</label>
              <div
                v-show="edit_depart_comp_data.errors.is_quick_company_err != ''"
                class="small text-danger p-0 m-0"
              >
                {{ edit_depart_comp_data.errors.is_quick_company_err }}
              </div>
              <div class="pb-2">
                <div class="form-check-inline">
                  <span class="form-check-label">
                    <input
                      type="radio"
                      class="form-check-input"
                      id="no"
                      :value="0"
                      :checked="
                        edit_depart_comp_data.form_data.is_quick_company === 0
                          ? true
                          : false
                      "
                      v-model="edit_depart_comp_data.form_data.is_quick_company"
                      @click="() => removeEditDepartOrCompFormErr('is_quick_company')"
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
                        edit_depart_comp_data.form_data.is_quick_company === 1
                          ? true
                          : false
                      "
                      v-model="edit_depart_comp_data.form_data.is_quick_company"
                      @click="() => removeEditDepartOrCompFormErr('is_quick_company')"
                    />Yes
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label class="form-label" for="email"
                >Email <span class="optional">(Optional)</span></label
              >
              <div
                class="text-danger small"
                v-show="edit_depart_comp_data.errors.email_err != ''"
              >
                {{ edit_depart_comp_data.errors.email_err }}
              </div>
              <input
                ref="firstInput"
                v-model="edit_depart_comp_data.form_data.email"
                type="text"
                class="form-control"
                id="email"
                name="email"
                maxlength="255"
                autocomplete="off"
                @focus="() => removeEditDepartOrCompFormErr('email')"
              />
            </div>
          </div>
          <div class="col-md-12 text-center">
            <div
              v-show="edit_depart_comp_data.errors.changes_err != ''"
              class="small text-danger p-0 m-0"
            >
              {{ edit_depart_comp_data.errors.changes_err }}
            </div>
            <AppButton customClass="mr-5" btnStyle="warn" :btnFunc="handleEditCancelBtn">
              Cancel
            </AppButton>

            <AppButton btnType="submit" customClass="btn-primary"> Save </AppButton>
          </div>
          <!-- end row -->
        </div>
      </form>
    </section>
    <!-- end form wrapper -->
  </div>
</template>

<script setup>
import { reactive } from "vue";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import LoadingIndicator from "../../shared/LoadingIndicator";
import { returnSystemErrorMsg, toSqlDatetime, validateEmail } from "../../helper/util";
import axios from "../../api/axios";

const props = defineProps({
  errors: Object,
  depart_comp: {
    type: Object,
    default: {},
  },
  depart_comp_index: {
    type: Number,
    default: null,
  },
});

const edit_depart_comp_data = reactive({
  is_edit_form_processing: false,
  edit_success: "",
  edit_error: "",
  form_data: {
    depart_comp_id: props.depart_comp?.id != null ? props.depart_comp?.id : 0,
    name: props.depart_comp?.name != null ? props.depart_comp?.name : "",
    old_name: props.depart_comp?.name != null ? props.depart_comp?.name : "",
    email: props.depart_comp?.email,
    old_email: props.depart_comp?.email,
    is_company:
      props.depart_comp?.is_depart_or_comp != null
        ? props.depart_comp?.is_depart_or_comp
        : "",
    is_quick_company:
      props.depart_comp?.is_quick != null ? props.depart_comp?.is_quick : "",
  },
  errors: {
    name_err: "",
    email_err: "",
    is_company_err: "",
    is_quick_company_err: "",
    changes_err: "",
  },
});

const emit = defineEmits(["updateDepartCompBeingEdited"]);

const handleEditCancelBtn = () => {
  edit_depart_comp_data.form_data.name = props.depart_comp?.name;
  edit_depart_comp_data.form_data.email = props.depart_comp?.email;
  edit_depart_comp_data.form_data.is_company = props.depart_comp?.is_depart_or_comp;
  edit_depart_comp_data.form_data.is_quick_company = props.depart_comp?.is_quick;
  const data_to_emit = {
    action: "cancel",
  };
  emit("updateDepartCompBeingEdited", data_to_emit);
};

const assignEditDepartOrCompFormErrors = (errorsArr) => {
  // console.log(errorsArr);
  errorsArr.forEach((error) => {
    if (error.toLowerCase().indexOf("make a change") > -1) {
      edit_depart_comp_data.errors.changes_err = error;
    }
    if (error.toLowerCase().indexOf("department or company name") > -1) {
      edit_depart_comp_data.errors.name_err = error;
    }

    if (error.toLowerCase().indexOf("department or company name") > -1) {
      edit_depart_comp_data.errors.name_err = error;
    }
    if (error.toLowerCase().indexOf("indicate if department or company") > -1) {
      edit_depart_comp_data.errors.is_company_err = error;
    }
    if (error.toLowerCase().indexOf("make it a quick company") > -1) {
      edit_depart_comp_data.errors.is_quick_company_err = error;
    }

    if (error.toLowerCase().indexOf("email") > -1) {
      edit_depart_comp_data.errors.email_err = error;
    }
  });
};

const removeEditDepartOrCompFormErr = (input_name) => {
  if (edit_depart_comp_data.errors.changes_err != "") {
    edit_depart_comp_data.errors.changes_err = "";
  }

  if (input_name == "name" && edit_depart_comp_data.errors.name_err != "") {
    edit_depart_comp_data.errors.name_err = "";
  }

  if (input_name == "is_company" && edit_depart_comp_data.errors.is_company_err != "") {
    edit_depart_comp_data.errors.is_company_err = "";
  }

  if (
    input_name == "is_quick_company" &&
    edit_depart_comp_data.errors.is_quick_company_err != ""
  ) {
    edit_depart_comp_data.errors.is_quick_company_err = "";
  }

  if (input_name == "email" && edit_depart_comp_data.errors.email_err != "") {
    edit_depart_comp_data.errors.email_err = "";
  }
};

const checkForEditDepartOrCompFormErrors = () => {
  let abort = false,
    errors_arr = [];

  //Check for changes
  if (
    edit_depart_comp_data.form_data.name == props.depart_comp?.name &&
    edit_depart_comp_data.form_data.is_company == props.depart_comp?.is_depart_or_comp &&
    edit_depart_comp_data.form_data.is_quick_company == props.depart_comp?.is_quick &&
    edit_depart_comp_data.form_data.email == props.depart_comp?.email
  ) {
    abort = true;
    errors_arr.push("Please make a change before saving thank you.");
  }

  if (edit_depart_comp_data.form_data.name == "") {
    abort = true;
    errors_arr.push("The department or company name field is required");
  }

  if (edit_depart_comp_data.form_data.is_company === "") {
    abort = true;
    errors_arr.push("Please indicate if department or company");
  }

  if (edit_depart_comp_data.form_data.is_company === 1) {
    if (edit_depart_comp_data.form_data.is_quick_company === "") {
      abort = true;
      errors_arr.push("Please indicate if to make it a quick company");
    }
  }

  if (
    edit_depart_comp_data.form_data.email != null &&
    edit_depart_comp_data.form_data.email != ""
  ) {
    if (!validateEmail(edit_depart_comp_data.form_data.email)) {
      abort = true;
      errors_arr.push("The email is invalid");
    }
  }

  return {
    abort,
    errors_arr,
  };
};

const handleEditFormSubmit = () => {
  const err_check = checkForEditDepartOrCompFormErrors();

  if (err_check.abort) {
    assignEditDepartOrCompFormErrors(err_check.errors_arr);
  } else {
    edit_depart_comp_data.is_edit_form_processing = true;
    setTimeout(async () => {
      try {
        const res = await axios.post(
          "/handle-depart-comp-update",
          edit_depart_comp_data.form_data
        );

        if (res?.data?.errors.length > 0) {
          assignEditDepartOrCompFormErrors(res?.data?.errors);
        } else {
          //success
          edit_depart_comp_data.edit_success = `Thanks, ${
            props.depart_comp?.is_depart_or_comp == 0 ? "department" : "company"
          } has been updated successfully`;
          setTimeout(() => {
            edit_depart_comp_data.edit_success = "";
            const data_to_emit = {
              action: "success",
              depart_comp_index: props.depart_comp_index,
              updated_date: toSqlDatetime(new Date()),
              updated_by_fname: res?.data?.updated_by_fname,
              updated_by_lname: res?.data?.updated_by_lname,
              name: edit_depart_comp_data.form_data.name,
              email:
                edit_depart_comp_data.form_data.email == ""
                  ? "---"
                  : edit_depart_comp_data.form_data.email,
              is_company: edit_depart_comp_data.form_data.is_company,
              is_quick_company: edit_depart_comp_data.form_data.is_quick_company,
            };
            emit("updateDepartCompBeingEdited", data_to_emit);
          }, 2000);
        }
      } catch (err) {
        edit_depart_comp_data.edit_error = returnSystemErrorMsg();
      } finally {
        edit_depart_comp_data.is_edit_form_processing = false;
      }
    }, 1000);
  } // end if abort
};
</script>
