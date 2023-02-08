<template>
  <Layout pageTitle="user-reset-password">
    <div class="container">
      <div class="row">
        <div class="col-md-7 mx-auto">
          <div class="page-intro-wrapper">
            <h1>Reset password</h1>
          </div>
          <div class="form-wrapper">
            <section v-if="processing"><LoadingIndicator /></section>
            <section v-if="!processing">
              <p class="form-top-text">Reset your password below.</p>

              <HandleMsg v-if="errors.fail" infotype="error" :msg="errors.fail" />

              <form @submit.prevent="handleResetForm">
                <div class="form-group">
                  <label class="form-label" for="password">Password *</label>
                  <div class="text-danger small" v-if="errors.password">
                    {{ errors.password }}
                  </div>
                  <div class="input-group mb-3">
                    <PasswordInput v-model="resetForm.password" />
                  </div>
                </div>

                <input
                  v-model="resetForm.myhouse"
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
import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";
import Layout from "../../shared/Layout";
import LoadingIndicator from "../../shared/LoadingIndicator";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import PasswordInput from "../../shared/PasswordInput";

let processing = ref(false);

const resetForm = reactive({
  password: "",
  myhouse: "",
});

defineProps({ errors: Object });

const handleResetForm = () => {
  router.post("/handle-reset-password", resetForm, {
    onStart: () => {
      processing.value = true;
    },
    onFinish: () => {
      processing.value = false;
    },
  });
};
</script>
