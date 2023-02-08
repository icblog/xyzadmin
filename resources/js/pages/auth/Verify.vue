<template>
  <title>
    {{ appName + " | verify-link" }}
  </title>
  <div class="container pb-5">
    <div class="row">
      <div class="col-md-7 mx-auto">
        <div class="text-center pt-5 pb-3">
          <Logo />
        </div>

        <div class="form-wrapper">
          <section v-if="processing"><LoadingIndicator /></section>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
//appDataObj.appName variable comes from views/app.blade.php
const appName = appDataObj.appName;
</script>
<script setup>
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import LoadingIndicator from "../../shared/LoadingIndicator";
import Logo from "../../shared/Logo";

let processing = ref(true);

defineProps({ errors: Object });

const handleVerifyLink = () => {
  setTimeout(() => {
    router.post(
      "/verify-link",
      {},
      {
        onFinish: () => {
          processing.value = false;
        },
      }
    );
  }, 1000);
};

onMounted(() => {
  handleVerifyLink();
});
</script>
