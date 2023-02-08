<template>
  <Layout pageTitle="notification">
    <div class="container">
      <div class="row">
        <div class="col-md-7 mx-auto">
          <div class="page-intro-wrapper text-center">
            <h1>Information</h1>
          </div>
          <div class="form-wrapper">
            <section>
              <HandleMsg
                v-if="msgData.type && msgData.type == 'error'"
                infotype="error"
                :msg="msgData.msg"
              />
              <HandleMsg
                v-if="msgData.type && msgData.type == 'success'"
                infotype="success"
                :msg="msgData.msg"
              />

              <HandleMsg
                v-if="msgData.type && msgData.type == 'info'"
                infotype="info"
                :msg="msgData.msg"
              />
            </section>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import Layout from "../shared/Layout";
import HandleMsg from "../shared/HandleMsg";

const props = defineProps({ msgData: Object });

onMounted(() => {
  if (props.msgData.redirectLink != "") {
    setTimeout(() => {
      router.visit(props.msgData.redirectLink);
    }, props.msgData.redirectTime);
  }
});
</script>
