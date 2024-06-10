<template>
  <Layout pageTitle="user-forgotten-password" pageIntro="Forgotten password">
    <div class="container">
      <div class="row pt-4">
        <div class="col-md-7 mx-auto pt-4">
          <div class="form-wrapper">
            <section v-if="processing"><LoadingIndicator /></section>
            <section v-if="respondsMsg == 'code200'">
              <HandleMsg
                infotype="info"
                :msg="mailSentInfoMsg"
                customClass="form-responds-msg"
              />
            </section>
            <section v-if="!processing && respondsMsg == ''">
              <p class="form-top-text">Enter your registered email below.</p>

              <HandleMsg v-if="errors.fail" infotype="error" :msg="errors.fail" />

              <form @submit.prevent="handleLoginForm">
                <div class="form-group">
                  <label class="form-label" for="email">Email*</label>
                  <div
                    class="text-danger small"
                    v-show="forgottenPasswordForm.formErrors.email != ''"
                  >
                    {{ forgottenPasswordForm.formErrors.email }}
                  </div>
                  <input
                    ref="firstInput"
                    v-model="forgottenPasswordForm.formData.email"
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    maxlength="255"
                    autocomplete="off"
                    @focus="removeForgottenPassFormErrors"
                  />
                </div>
                <input
                  v-model="forgottenPasswordForm.formData.myhouse"
                  type="text"
                  maxlength="2"
                  name="myhouse"
                  class="not_in_my_house"
                />
                <p class="small">All fields marked with a * are mandatory</p>
                <div class="pt-3 text-center">
                  <AppButton :fullBtn="true" btnType="submit" btnStyle="primary"
                    >Submit</AppButton
                  >
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
import { reactive, ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import Layout from "../../shared/Layout";
import LoadingIndicator from "../../shared/LoadingIndicator";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import {
  focusOnFirstInput,
  validateEmail,
  scrollToTopOrBottomOfPage,
} from "../../helper/util";

let processing = ref(false),
  firstInput = ref(null);
const mailSentInfoMsg =
  "Please check your email and follow the instruction to continue if you have account thank you.";

const forgottenPasswordForm = reactive({
  formData: {
    email: "",
    myhouse: "",
  },
  formErrors: {
    email: "",
  },
});

const props = defineProps({
  errors: Object,
  respondsMsg: {
    type: String,
    default: "",
  },
});

const assignForgottenPassFormErrors = (errObj) => {
  if (errObj?.email !== undefined) {
    forgottenPasswordForm.formErrors.email = errObj?.email;
  }
};

const removeForgottenPassFormErrors = () => {
  forgottenPasswordForm.formErrors.email = "";
};

const handleLoginForm = () => {
  let abort = false;

  if (forgottenPasswordForm.formData.email == "") {
    abort = true;
    forgottenPasswordForm.formErrors.email = "The email field is required";
  }

  if (forgottenPasswordForm.formData.email != "") {
    if (!validateEmail(forgottenPasswordForm.formData.email)) {
      abort = true;
      forgottenPasswordForm.formErrors.email = "The email is invalid";
    }
  }

  if (!abort) {
    scrollToTopOrBottomOfPage();
    setTimeout(() => {
      router.post("/handle-forgotten-password-form", forgottenPasswordForm.formData, {
        onStart: () => {
          processing.value = true;
        },
        onFinish: () => {
          processing.value = false;
          setTimeout(() => {
            if (props.respondsMsg == "code200") {
              router.get("/");
            }
          }, 8000);
        },
        onError: (errors) => {
          assignForgottenPassFormErrors(errors);
        },
      });
    }, 100);
  } //end if abort is false
};

onMounted(() => {
  focusOnFirstInput(firstInput);
});
</script>
