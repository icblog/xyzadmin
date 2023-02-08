<template>
  <div class="text-right">
    <AppButton :btnFunc="closeContactModalIfOpen" btnStyle="secondary">X</AppButton>
  </div>
  <div class="text-center mt-2">
    <h1>Contact</h1>
  </div>

  <div class="register-stepper">
    <div
      class="step"
      :class="{ 'step-active': stepData.step === 1, 'step-done': stepData.step > 1 }"
    >
      <span class="step-number">1</span>
    </div>
    <div
      class="step"
      :class="{ 'step-active': stepData.step === 2, 'step-done': stepData.step > 2 }"
    >
      <span class="step-number">2</span>
    </div>
    <div
      class="step"
      :class="{ 'step-active': stepData.step === 3, 'step-done': stepData.step > 3 }"
    >
      <span class="step-number">3</span>
    </div>
  </div>
  <!-- End register-stepper -->
  <div class="form-wrapper">
    <section v-if="processing"><LoadingIndicator /></section>
    <section v-if="!processing">
      <!-- <HandleMsg v-if="errors.fail" infotype="error" :msg="errors.fail" /> -->

      <form @submit.prevent="handleContactForm">
        <Transition name="slide-fade">
          <section v-show="stepData.step === 1">
            <div class="form-group">
              <label class="form-label" for="name">Name*</label>
              <div class="text-danger small" v-if="stepData.nameErr">
                {{ stepData.nameErr }}
              </div>
              <input
                v-model="contactFormData.name"
                type="text"
                class="form-control"
                id="name"
                name="name"
                maxlength="255"
                autocomplete="off"
                required
              />
            </div>
            <div class="text-right">
              <AppButton :btnFunc="nextStep1" btnStyle="secondary">Next</AppButton>
            </div>
          </section>
        </Transition>

        <section v-show="stepData.step === 2">
          <div class="form-group">
            <label class="form-label" for="email">Email*</label>
            <div class="text-danger small" v-if="stepData.emailErr">
              {{ stepData.emailErr }}
            </div>
            <input
              v-model="contactFormData.email"
              type="email"
              class="form-control"
              id="email"
              name="email"
              maxlength="255"
              autocomplete="off"
              required
            />
          </div>

          <div class="cf">
            <div class="float-left">
              <AppButton :btnFunc="previousStep" btnStyle="secondary">Back</AppButton>
            </div>
            <div class="float-right">
              <AppButton :btnFunc="nextStep2" btnStyle="secondary">Next</AppButton>
            </div>
          </div>
        </section>

        <section v-show="stepData.step === 3">
          <div class="form-group">
            <label class="form-label" for="message">Message *</label>
            <div class="text-danger small" v-if="stepData.messageErr">
              {{ stepData.messageErr }}
            </div>
            <textarea
              v-model="contactFormData.message"
              class="form-control"
              id="message"
              maxlength="6000"
              autocomplete="off"
            >
            </textarea>
          </div>
          <div class="cf">
            <div class="float-left">
              <AppButton :btnFunc="previousStep" btnStyle="secondary">Back</AppButton>
            </div>
            <div class="float-right">
              <AppButton btnType="submit" btnStyle="primary">Submit</AppButton>
            </div>
          </div>
        </section>
      </form>
    </section>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted, Transition } from "vue";
import { router } from "@inertiajs/vue3";
import LoadingIndicator from "../shared/LoadingIndicator";
import HandleMsg from "../shared/HandleMsg";
import AppButton from "../shared/AppButton";
import { focusOnFirstInput } from "../helper/util";
import { validateEmail } from "../helper/formValidation";

let processing = ref(false);

const contactFormData = reactive({
  name: "",
  email: "",
  message: "",
  myhouse: "",
});

const stepData = reactive({
  step: 1,
  nameErr: "",
  emailErr: "",
  messageErr: "",
});

const props = defineProps({
  errors: {
    type: Object,
  },
  closeContactModal: {
    type: Function,
    default: null,
  },
});


const assignFormErrors = () => {
  if (props.errors != undefined) {
    stepData.nameErr = props.errors.name || "";
    stepData.emailErr = props.errors.email || "";
    stepData.messageErr = props.errors.message || "";
  } else {
    stepData.nameErr = "";
    stepData.emailErr = "";
    stepData.messageErr = "";
  }
};

const resetFormValues = () => {
  contactFormData.name = "";
  contactFormData.email = "";
  contactFormData.message = "";
  contactFormData.myhouse = "";
};

const nextStep1 = () => {

  if (contactFormData.name === "") {
    stepData.nameErr = "Name field is required";
  } else {
    stepData.nameErr = "";
    stepData.step++;
  }
};

const nextStep2 = () => {
  if (contactFormData.email === "") {
    stepData.emailErr = "Email field is required";
  } else if (!validateEmail(contactFormData.email)) {
    stepData.emailErr = "Enter a valid email address";
  } else {
    stepData.emailErr = "";
    stepData.step++;
  }
};

const previousStep = () => {
  assignFormErrors();
  stepData.step--;
};

const closeContactModalIfOpen = () => {
  stepData.step = 1;
  assignFormErrors();
  props.closeContactModal();
  resetFormValues();
};

const handleContactForm = () => {
  //Validate last step
  if (contactFormData.message === "") {
    stepData.messageErr = "Message field is required";
    return;
  } else {
    stepData.messageErr = "";

    router.post("/handle-contact", contactFormData, {
      onStart: () => {
        processing.value = true;
      },
      onFinish: () => {
        processing.value = false;
        assignFormErrors();
      },
    });
  }
};
</script>
