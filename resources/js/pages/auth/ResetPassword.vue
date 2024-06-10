<template>
  <Layout pageTitle="user-reset-password" pageIntro="Reset password">
    <div class="container">
      <div class="row pt-4">
        <div class="col-md-7 mx-auto pt-4">
          <HandleMsg
            v-show="systemPassUsed == 'yes'"
            infotype="info"
            msg="You have been redirected to change your password because you're using
                system generated password."
            customClass="form-responds-msg mb-3"
          />
          <div class="form-wrapper">
            <section v-if="processing"><LoadingIndicator /></section>
            <section v-if="respondsMsg == 'code200'">
              <HandleMsg
                infotype="success"
                msg="Password change successfully"
                customClass="form-responds-msg"
              />
            </section>

            <section v-if="!processing && respondsMsg == ''">
              <p v-show="systemPassUsed != 'yes'" class="form-top-text">
                Reset your password below.
              </p>

              <HandleMsg
                v-show="errors.fail"
                infotype="error"
                :msg="errors.fail"
                customClass="form-responds-msg"
              />

              <form @submit.prevent="handleResetForm">
                <div v-if="systemPassUsed == 'yes'" class="form-group">
                  <label class="form-label" for="oldpassword">Old Password *</label>
                  <div
                    class="text-danger small"
                    v-show="resetForm.formErrors.oldpassword != ''"
                  >
                    {{ resetForm.formErrors.oldpassword }}
                  </div>
                  <div class="input-group mb-3">
                    <PasswordInput
                      v-model="resetForm.formdata.oldpassword"
                      :inputFocusFunc="removeResetPassFormErrors"
                      inputName="oldpassword"
                    />
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label" for="password"
                    >{{ systemPassUsed == "yes" ? "New" : "" }} Password *</label
                  >
                  <div
                    class="text-danger small"
                    v-show="resetForm.formErrors.password != ''"
                  >
                    {{ resetForm.formErrors.password }}
                  </div>
                  <div class="input-group mb-3">
                    <PasswordInput
                      v-model="resetForm.formdata.password"
                      :inputFocusFunc="removeResetPassFormErrors"
                    />
                  </div>
                </div>

                <input
                  v-model="resetForm.formdata.myhouse"
                  type="text"
                  maxlength="2"
                  name="myhouse"
                  class="not_in_my_house"
                />
                <p class="small">All fields marked with a * are mandatory</p>

                <div class="pt-3 text-center">
                  <AppButton :fullBtn="true" btnType="submit" btnStyle="primary">Submit</AppButton>
                </div>
              </form>
            </section>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";
import Layout from "../../shared/Layout";
import LoadingIndicator from "../../shared/LoadingIndicator";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import PasswordInput from "../../shared/PasswordInput";
import { scrollToTopOrBottomOfPage } from "../../helper/util";
let processing = ref(false);

const resetForm = reactive({
  formdata: {
    oldpassword: "",
    password: "",
    myhouse: "",
    systemPassUsed: props.systemPassUsed,
  },
  formErrors: {
    oldpassword: "",
    password: "",
  },
});

const props = defineProps({
  errors: Object,
  systemPassUsed: {
    type: String,
    default: "no",
  },
  respondsMsg: {
    type: String,
    default: "",
  },
});

const assignResetPassFormErrors = (errObj) => {
  if (errObj?.oldpassword !== undefined) {
    resetForm.formErrors.oldpassword = errObj?.oldpassword;
  }

  if (errObj.password !== undefined) {
    resetForm.formErrors.password = errObj.password;
  }
};

const removeResetPassFormErrors = (inputName) => {
  if (inputName == "oldpassword") {
    resetForm.formErrors.oldpassword = "";
  }

  if (inputName == "password") {
    resetForm.formErrors.password = "";
  }
};

const handleResetForm = () => {
  let abort = false;
  if (props.systemPassUsed == "yes") {
    if (resetForm.formdata.oldpassword == "") {
      abort = true;
      resetForm.formErrors.oldpassword = "Old password is required";
    }

    if (resetForm.formdata.password == "") {
      abort = true;
      resetForm.formErrors.password = "New password is required";
    }
  } else {
    if (resetForm.formdata.password == "") {
      abort = true;
      resetForm.formErrors.password = "Password is required";
    }
  }

  if (!abort) {
    scrollToTopOrBottomOfPage();
    setTimeout(() => {
      router.post("/handle-reset-password", resetForm.formdata, {
        onStart: () => {
          processing.value = true;
        },
        onFinish: () => {
          processing.value = false;
          setTimeout(() => {
            if (props.respondsMsg == "code200") {
              router.get("/");
            }
          }, 1000);
        },
        onError: (errors) => {
          assignResetPassFormErrors(errors);
        },
      });
    }, 100);
  } // end abort
};
</script>
