<template>
  <div class="container">
    <header>
      <div class="row">
        <div class="col-md-12 text-center">
          <Logo />
        </div>
      </div>
      <hr />
      <div class="row pt-2">
        <div class="col">
          <h5 class="date-time">Admin-{{ pageIntro }}</h5>
        </div>
        <div class="col">
          <h5 class="date-time">Date: {{ currentTimeStampData.currentDate }}</h5>
        </div>
        <div class="col">
          <h5 class="date-time">Time: {{ currentTimeStampData.currentTime }}</h5>
        </div>
        <div v-if="backUrl != ''" class="col iv-go-back-btn-wrapper">
          <AppLink :linkUrl="backUrl" className="iv-go-back-btn primary-btn">
            <i class="fas fa-arrow-left"></i>
            Go back
          </AppLink>
        </div>
      </div>
      <hr />
    </header>
  </div>
</template>

<script setup>
import { reactive, onMounted } from "vue";
import AppLink from "./AppLink.vue";
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
