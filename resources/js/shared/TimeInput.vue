<template>
  <div class="time-input-wrapper">
    <input
      v-model="hour_value"
      type="text"
      maxlength="2"
      class="mini_input"
      placeholder="00"
      @input="moveToNext($event)"
      @focus="inputFocusFunc"
    />
    <div class="colon">:</div>
    <input
      v-model="minutes_value"
      type="text"
      ref="minutes_input"
      maxlength="2"
      placeholder="00"
      class="mini_input"
      @focus="inputFocusFunc"
    />
  </div>
</template>
<script setup>
import { watch, ref, onMounted } from "vue";

let hour_value = ref(""),
  minutes_value = ref(""),
  minutes_input = ref(null);

const emit = defineEmits(["updateTimeValue"]);

const props = defineProps({
  default_time: {
    type: String,
    default: "",
  },
  inputFocusFunc: {
    type: Function,
    default: () => {},
  },
});

const moveToNext = (event) => {
  if (event.target.value.length === event.target.maxLength) {
    minutes_input.value.focus();
  }
};

watch([hour_value, minutes_value], ([new_hour_value, new_minutes_value]) => {
  if (new_hour_value != "" && new_minutes_value != "") {
    emit("updateTimeValue", new_hour_value + ":" + new_minutes_value);
  }
});

onMounted(() => {
  if (props.default_time != "") {
    hour_value.value = props.default_time.split(":")[0];
    minutes_value.value = props.default_time.split(":")[1];
  }
});
</script>
