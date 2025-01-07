<template>
  <Layout pageTitle="user-login" pageIntro="Login">
    <div class="container-fluid">
      <div class="row pt-4">
        <div class="col-md-7 mx-auto pt-4">
          <div class="form-wrapper">
            <section v-if="processing"><LoadingIndicator /></section>
            <section v-if="!processing">
              <p class="form-top-text">
                Enter your login details below or email me @
                <span class="bolded small">isaaccobbinah.live@gmail.com</span>
                for access if you're a recruiter thank you.
              </p>

              <HandleMsg
                v-if="errors.fail"
                infotype="error"
                :msg="errors.fail"
                customClass="form-responds-msg"
              />

              <form @submit.prevent="handleLoginForm">
                <div class="form-group">
                  <label class="form-label" for="email_username">Email/Username *</label>
                  <div
                    class="text-danger small"
                    v-if="loginFormData.loginFormErr.email_username != ''"
                  >
                    {{ loginFormData.loginFormErr.email_username }}
                  </div>
                  <input
                    ref="firstInput"
                    v-model="loginFormData.formData.email_username"
                    type="text"
                    class="form-control"
                    id="email_username"
                    name="email_username"
                    maxlength="255"
                    autocomplete="off"
                    @focus="() => removeLoginFormErrors('username_email')"
                  />
                </div>

                <div class="form-group">
                  <label class="form-label" for="password">Password *</label>
                  <div
                    class="text-danger small"
                    v-if="loginFormData.loginFormErr.password != ''"
                  >
                    {{ loginFormData.loginFormErr.password }}
                  </div>
                  <div class="input-group mb-3">
                    <PasswordInput
                      v-model="loginFormData.formData.password"
                      :inputFocusFunc="removeLoginFormErrors"
                    />
                  </div>
                </div>

                <input
                  v-model="loginFormData.formData.myhouse"
                  type="text"
                  maxlength="2"
                  name="myhouse"
                  class="not_in_my_house"
                />
                <p class="small">All fields marked with a * are mandatory</p>
                <div class="cf">
                  <AppLink linkUrl="/forgotten-password" className="float-left small"
                    >Forgotten password?</AppLink
                  >
                </div>
                <div class="pt-3 text-center">
                  <AppButton :fullBtn="true" btnType="submit" btnStyle="primary"
                    >Login</AppButton
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
import { focusOnFirstInput, scrollToTopOrBottomOfPage } from "../../helper/util";
import PasswordInput from "../../shared/PasswordInput";
import AppButton from "../../shared/AppButton";
import AppLink from "../../shared/AppLink";

let processing = ref(false),
  firstInput = ref(null);

defineProps({ errors: Object });

const loginFormData = reactive({
  formData: {
    email_username: "",
    password: "",
    myhouse: "",
  },
  loginFormErr: {
    email_username: "",
    password: "",
  },
});

const assignLoginFormErrors = (errObj) => {
  if (errObj?.email_username !== undefined) {
    loginFormData.loginFormErr.email_username = errObj?.email_username;
  }

  if (errObj.password !== undefined) {
    loginFormData.loginFormErr.password = errObj.password;
  }
};

const removeLoginFormErrors = (inputName) => {
  if (inputName == "username_email") {
    loginFormData.loginFormErr.email_username = "";
  }

  if (inputName == "password") {
    loginFormData.loginFormErr.password = "";
  }
};

const handleLoginForm = () => {
  //Validate the form
  let abort = false;
  if (loginFormData.formData.email_username == "") {
    abort = true;
    loginFormData.loginFormErr.email_username = "Username or email field is required";
  }

  if (loginFormData.formData.email_username == "") {
    abort = true;
    loginFormData.loginFormErr.password = "Password field is required";
  }

  if (!abort) {
    scrollToTopOrBottomOfPage();
    setTimeout(() => {
      router.post("/handle-login-form", loginFormData.formData, {
        onStart: () => {
          processing.value = true;
        },
        onFinish: () => {
          processing.value = false;
        },
        onError: (errors) => {
          assignLoginFormErrors(errors);
        },
      });
    }, 100);
  } //end if abort if false
};

onMounted(() => {
  focusOnFirstInput(firstInput);
});
</script>
