<template>
  <input
    :value="modelValue"
    @input="updateValue"
    :type="isPasswordVisible ? 'text' : 'password'"
    id="password"
    name="password"
    class="login-pwd form-control"
    maxlength="30"
    autocomplete="off"
    @focus="() => inputFocusFunc(inputName)"
  />
  <div class="password-visible-btn input-group-append">
    <span
      @click="togglePasswordVisibilty"
      class="no-border-radius password-visibility-btn input-group-text"
    >
      <span><i :class="isPasswordVisible ? 'fa fa-eye-slash' : 'fa fa-eye'"></i></span>
    </span>
  </div>
</template>

<script setup>
import { ref } from "vue";

let isPasswordVisible = ref(false);

const togglePasswordVisibilty = () => {
  isPasswordVisible.value = !isPasswordVisible.value;
};

const props = defineProps({
  modelValue: {
    type: String,
    default: "",
  },
  inputName: {
    type: String,
    default: "password",
  },

  inputFocusFunc: {
    type: Function,
    default: () => {},
  },
});

const emit = defineEmits();

const updateValue = (event) => {
  emit("update:modelValue", event.target.value);
};
</script>
