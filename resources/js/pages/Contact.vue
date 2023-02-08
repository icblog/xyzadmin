<template>
  <Layout pageTitle="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="page-intro-wrapper">
            <h1>Contact</h1>
            <p>
              Use the form below to message me and I will get back to you as soon as I can
              thank you.
            </p>
          </div>
          <div class="form-wrapper">
            <section v-if="processing"><LoadingIndicator /></section>
            <section v-if="!processing">
              <HandleMsg
                v-if="props.errors.fail"
                infotype="error"
                :msg="props.errors.fail"
              />

              <form @submit.prevent="handleContactForm">
                <div class="form-group">
                  <label class="form-label" for="username">Name*</label>
                  <div class="text-danger small" v-if="props.errors.name">
                    {{ props.errors.name }}
                  </div>
                  <input
                    ref="firstInput"
                    v-model="contactForm.name"
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    maxlength="255"
                    autocomplete="off"
                    required
                  />
                </div>

                <div class="form-group">
                  <label class="form-label" for="email">Email*</label>
                  <div class="text-danger small" v-if="props.errors.email">
                    {{ props.errors.email }}
                  </div>
                  <input
                    v-model="contactForm.email"
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    maxlength="255"
                    autocomplete="off"
                    required
                  />
                </div>

                <div class="form-group">
                  <label class="form-label" for="message">Message *</label>
                  <div class="text-danger small" v-if="props.errors.message">
                    {{ props.errors.message }}
                  </div>
                  <textarea
                    v-model="contactForm.message"
                    class="form-control"
                    id="message"
                    maxlength="6000"
                    autocomplete="off"
                    required
                  >
                  </textarea>
                </div>

                <input
                  v-model="contactForm.myhouse"
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
import LoadingIndicator from "../shared/LoadingIndicator";
import Layout from "../shared/Layout.vue";
import HandleMsg from "../shared/HandleMsg";
import AppButton from "../shared/AppButton";

import { focusOnFirstInput } from "../helper/util";

let processing = ref(false),
  firstInput = ref(null);

const contactForm = reactive({
  name: "",
  email: "",
  message: "",
  myhouse: "",
});

const props = defineProps({
  errors: Object,
});

const handleContactForm = () => {
  router.post("/handle-contact", contactForm, {
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
