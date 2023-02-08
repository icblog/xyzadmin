<template>
  <Layout pageTitle="user-forgotten-password">
    <div class="container">
      <div class="row">
        <div class="col-md-7 mx-auto">
          <div class="page-intro-wrapper">
            <h1>Forgotten password</h1>
          </div>
          <div class="form-wrapper">
            <section v-if="processing"><LoadingIndicator /></section>
            <section v-if="!processing">
              <p class="form-top-text">
                Enter your registered email below, a link will be sent to reset your
                password if you have account.
              </p>

              <HandleMsg v-if="errors.fail" infotype="error" :msg="errors.fail" />

              <form @submit.prevent="handleLoginForm">
                <div class="form-group">
                  <label class="form-label" for="email">Email*</label>
                  <div class="text-danger small" v-if="errors.email">
                    {{ errors.email }}
                  </div>
                  <input
                    ref="firstInput"
                    v-model="forgottenPasswordForm.email"
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    maxlength="255"
                    autocomplete="off"
                    required
                  />
                </div>
                <input
                  v-model="forgottenPasswordForm.myhouse"
                  type="text"
                  maxlength="2"
                  name="myhouse"
                  class="not_in_my_house"
                />
                <p class="small">All fields marked with a * are mandatory</p>
                <div class="pt-3 text-center">
                  <AppButton btnType="submit" btnStyle="primary">Submit</AppButton>
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
import { focusOnFirstInput } from "../../helper/util";

let processing = ref(false),
  firstInput = ref(null);

const forgottenPasswordForm = reactive({
  email: "",
  myhouse: "",
});

defineProps({ errors: Object });

const handleLoginForm = () => {
  router.post("/handle-forgotten-password-form", forgottenPasswordForm, {
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
