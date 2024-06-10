<template>
  <div class="text-center">
    <AppButton
      :btnFunc="() => handleAfterSuccessBtn(click_action_add)"
      customClass="change-selected-btn pt-2 pb-2 pl-5 pr-5 mr-5"
    >
      {{ add_btn_name }}</AppButton
    >
    <AppButton
      :btnFunc="() => handleAfterSuccessBtn(click_action_redirect)"
      customClass="change-selected-btn pt-2 pb-2 pl-5 pr-5"
      >{{ redirect_btn_name }}</AppButton
    >
  </div>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import AppButton from "./AppButton";

const emit = defineEmits(["updateSuccessCancelTimer"]);

const props = defineProps({
  add_link_name: {
    type: String,
    default: "/",
  },
  redirect_link_name: {
    type: String,
    default: "/",
  },

  click_action_add: {
    type: String,
    default: "",
  },
  click_action_redirect: {
    type: String,
    default: "",
  },
  add_btn_name: {
    type: String,
    default: "",
  },
  redirect_btn_name: {
    type: String,
    default: "",
  },
});

const handleAfterSuccessBtn = (click_action) => {
  emit("updateSuccessCancelTimer");

  if (click_action == props.click_action_add) {
    router.get(props.add_link_name);
  } else if (click_action == props.click_action_redirect) {
    router.get(props.redirect_link_name);
  }
};
</script>
