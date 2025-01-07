<template>
  <title>
    {{ appName + " | verify-link" }}
  </title>
  <div class="container-fluid pb-5">
    <div class="row">
      <div class="col-md-7 mx-auto">
        <div class="text-center pt-5 pb-3">
          <Logo />
        </div>

        <div class="form-wrapper">
          <section v-if="processing"><LoadingIndicator /></section>
          <section v-if="!processing && respondsMsg == 'code000'">
            <HandleMsg
              infotype="error"
              :msg="verifyErrormsg1"
              customClass="form-responds-msg"
            />
          </section>
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
import HandleMsg from "../../shared/HandleMsg";

let processing = ref(false);
const verifyErrormsg1 =
  "Sorry the link has expired or Invalid,  you will be redirected to create a new one thank you.";

const props = defineProps({
  errors: Object,
  respondsMsg: {
    type: String,
    default: "",
  },
});

const handleVerifyLink = () => {
  if (props.respondsMsg == "") {
    processing.value = true;
    setTimeout(() => {
      router.post(
        "/verify-link",
        {},
        {
          onFinish: () => {
            processing.value = false;
            setTimeout(() => {
              if (props.respondsMsg == "code000") {
                router.get("/forgotten-password");
              }
            }, 8000);
          },
        }
      );
    }, 1000);
  }
};

onMounted(() => {
  handleVerifyLink();
});
</script>
