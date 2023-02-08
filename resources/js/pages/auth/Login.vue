<template>
  <Layout pageTitle="user-login">
    <div class="container">
      <div class="row">
        <div class="col-md-7 mx-auto">
          <div class="page-intro-wrapper">
            <h1>Welcome back</h1>
          </div>
          <div class="form-wrapper">
            <section v-if="processing"><LoadingIndicator /></section>
            <section v-if="!processing">
              <p class="form-top-text">Enter your login in details below.</p>

              <HandleMsg v-if="errors.fail" infotype="error" :msg="errors.fail" />

              <form @submit.prevent="handleLoginForm">
                <div class="form-group">
                  <label class="form-label" for="email_username">Email/Username *</label>
                  <div class="text-danger small" v-if="errors.email_username">
                    {{ errors.email_username }}
                  </div>
                  <input
                    ref="firstInput"
                    v-model="loginForm.email_username"
                    type="text"
                    class="form-control"
                    id="email_username"
                    name="email_username"
                    maxlength="255"
                    autocomplete="off"
                    required
                  />
                </div>

                <div class="form-group">
                  <label class="form-label" for="password">Password *</label>
                  <div class="text-danger small" v-if="errors.password">
                    {{ errors.password }}
                  </div>
                  <div class="input-group mb-3">
                    <PasswordInput v-model="loginForm.password" />
                  </div>
                </div>

                <input
                  v-model="loginForm.myhouse"
                  type="text"
                  maxlength="2"
                  name="myhouse"
                  class="not_in_my_house"
                />
                <p class="small">All fields marked with a * are mandatory</p>
                <div class="cf">
                  <AppLink linkUrl="/forgotten-password" className="float-left"
                    >Forgotten password?</AppLink
                  >
                  <AppLink linkUrl="/register" className="float-right">Register</AppLink>
                </div>
                <div class="pt-3 text-center">
                  <AppButton btnType="submit" btnStyle="primary">Login</AppButton>
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
import { focusOnFirstInput } from "../../helper/util";
import PasswordInput from "../../shared/PasswordInput";
import AppButton from "../../shared/AppButton";
import AppLink from "../../shared/AppLink";

let processing = ref(false),
  firstInput = ref(null);

const loginForm = reactive({
  email_username: "",
  password: "",
  myhouse: "",
});

defineProps({ errors: Object });

const handleLoginForm = () => {
  router.post("/handle-login-form", loginForm, {
    onStart: () => {
      processing.value = true;
    },
    onFinish: () => {
      processing.value = false;
    },
  });
};

onMounted(() => {
  focusOnFirstInput(firstInput);
});
</script>
