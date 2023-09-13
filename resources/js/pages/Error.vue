<template>
  <title>
    {{ appName + " | " + title }}
  </title>
  <div class="container pb-5">
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="pt-2 pb-5">
          <Logo />
        </div>
        <h1 class="pl-4 pt-5">{{ title }}</h1>
        <div class="form-wrapper">
          <p class="pt-4">{{ description }}</p>
          <p><AppLink linkUrl="/" className="primary-btn">Go to home page</AppLink></p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
const appName = appDataObj.appName;
</script>

<script setup>
import { computed } from "vue";
import Logo from "../shared/Logo.vue";
import AppLink from "../shared/AppLink.vue";

const props = defineProps({ status: Number });

const title = computed(() => {
  return {
    503: "503: Service Unavailable",
    500: "500: Server Error",
    404: "404: Page Not Found",
    403: "403: Forbidden",
  }[props.status];
});

const description = computed(() => {
  return {
    503: "Sorry, we are doing some maintenance. Please check back soon.",
    500: "Whoops, something went wrong on our servers.",
    404: "Sorry, the page you are looking for could not be found.",
    403: "Sorry, you are forbidden from accessing this page.",
  }[props.status];
});
</script>
