<template>
  <Layout pageTitle="user-complete-register">
    <div class="container">
      <div class="row">
        <div class="col-md-7 mx-auto">
          <div class="page-intro-wrapper">
            <h1>Complete your account</h1>
          </div>
          <div class="form-wrapper">
            <section v-if="processing"><LoadingIndicator /></section>
            <section v-if="!processing">
              <HandleMsg v-if="errors.fail" infotype="error" :msg="errors.fail" />

              <form @submit.prevent="handleCompleteRegisterForm">
                <div class="form-group">
                  <label class="form-label" for="username">Username*</label>
                  <div class="text-danger small" v-if="errors.username">
                    {{ errors.username }}
                  </div>
                  <input
                    ref="firstInput"
                    v-model="completeRegisterForm.username"
                    type="text"
                    class="form-control"
                    id="username"
                    name="username"
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
                    <PasswordInput v-model="completeRegisterForm.password" />
                  </div>
                </div>

                <input
                  v-model="completeRegisterForm.myhouse"
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
import PasswordInput from "../../shared/PasswordInput";
import { focusOnFirstInput } from "../../helper/util";

let processing = ref(false),
  firstInput = ref(null);

const completeRegisterForm = reactive({
  password: "",
  myhouse: "",
  username: "",
});

defineProps({ errors: Object });

const handleCompleteRegisterForm = () => {
  router.post("/handle-complete-register", completeRegisterForm, {
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
