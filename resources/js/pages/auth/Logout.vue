<template>
  <Layout pageTitle="user-logout" pageIntro="logout">
    <div class="container">
      <div class="row pt-4">
        <div class="col-md-7 mx-auto pt-4">
          <div class="form-wrapper">
            <section v-if="processing"><LoadingIndicator /></section>
            <section v-if="!processing && respondsMsg == 'code200'">
              <HandleMsg
                infotype="success"
                msg="You've logout successful"
                customClass="form-responds-msg"
              />
            </section>

            <section v-if="!processing && respondsMsg == 'code000'">
              <HandleMsg
                infotype="error"
                msg="Sorry system error, please clear your browser history or close your browser and your session should be destroyed thank you"
                customClass="form-responds-msg"
              />
            </section>
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
import HandleMsg from "../../shared/HandleMsg";
import LoadingIndicator from "../../shared/LoadingIndicator";

let processing = ref(true);

const props = defineProps({
  errors: Object,
  respondsMsg: {
    type: String,
    default: "",
  },
});

const handleLogout = () => {
  setTimeout(() => {
    router.post(
      "/handle-logout",
      {},
      {
        onFinish: () => {
          processing.value = false;
          setTimeout(() => {
            if (props.respondsMsg == "code200") {
              router.get("/");
            }
          }, 1000);
        },
      }
    );
  }, 1000);
};

onMounted(() => {
  handleLogout();
});
</script>
