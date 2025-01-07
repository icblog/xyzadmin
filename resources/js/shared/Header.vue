<template>
  <header>
    <div class="container">
      <div class="row">
        <div class="col">
          <Logo />
        </div>
        <div class="col">
          <h5 class="date-time">Date: {{ currentTimeStampData.currentDate }}</h5>
        </div>
        <div class="col">
          <h5 class="date-time">Time: {{ currentTimeStampData.currentTime }}</h5>
        </div>
      </div>
    </div>
  </header>

  <div class="container pt-1">
    <div class="row justify-content-end pt-5 pb-3 text-center">
      <div class="col-9">
        <h5>{{ pageIntro }}</h5>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, onMounted } from "vue";
import Logo from "./Logo.vue";
import { returnCurrentDate, returnCurrentTime } from "../helper/util";

defineProps({
  backUrl: {
    type: String,
    default: "",
  },

  pageIntro: {
    type: String,
    default: "",
  },
});

const currentTimeStampData = reactive({
  currentDate: "",
  currentTime: "",
  interval: 0,
});

const currentDateTime = () => {
  currentTimeStampData.currentDate = returnCurrentDate();
  currentTimeStampData.currentTime = returnCurrentTime();
};

onMounted(() => {
  setTimeout(() => {
    currentDateTime();
  }, 50);
  setInterval(() => {
    currentDateTime();
  }, 1000);
});
</script>
