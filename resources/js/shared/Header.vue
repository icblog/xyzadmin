<template>
  <div class="container">
    <header>
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
      <hr />
      <div class="row">
        <div class="col-md-6 mx-auto text-center">
          <h5 class="date-time">{{ pageIntro }}</h5>
        </div>
      </div>
      <hr />
    </header>
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
