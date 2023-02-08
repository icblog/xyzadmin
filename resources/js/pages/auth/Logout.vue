<template>
  <Layout pageTitle="user-logout">
    <div class="container">
      <div class="row">
        <div class="col-md-7 mx-auto">
          <div class="page-intro-wrapper">
            <h1>Logout</h1>
          </div>
          <div class="form-wrapper">
            <section v-if="processing"><LoadingIndicator /></section>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import Layout from "../../shared/Layout";
import LoadingIndicator from "../../shared/LoadingIndicator";

let processing = ref(true);

defineProps({ errors: Object });

const handleLogout = () => {
  setTimeout(() => {
    router.post(
      "/handle-logout",
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
  handleLogout();
});
</script>
