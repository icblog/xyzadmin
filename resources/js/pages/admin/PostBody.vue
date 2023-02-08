<template>
  <div class="form-group">
    <div class="cf">
      <label class="form-label float-left" for="body">Post body *</label>
      <span class="float-right mb-2"
        ><AppButton btnStyle="secondary" :btnFunc="togglePreview"
          ><span
            >{{ postBodyData.isPreviewVisible ? "Edit " : "Preview "
            }}<i
              :class="postBodyData.isPreviewVisible ? 'fa fa-eye-slash' : 'fa fa-eye'"
            ></i></span></AppButton
      ></span>
    </div>
    <div
      class="text-danger small"
      v-if="postBodyError != '' || postBodyData.previewError != ''"
    >
      {{ props.postBodyError }}<br />
      {{ postBodyData.previewError }}
    </div>
    <div v-if="postBodyData.isPreviewVisible" class="editor-preview-wrapper">
      <Markdown :source="props.modelValue" />
    </div>
    <textarea
      v-if="!postBodyData.isPreviewVisible"
      :value="modelValue"
      @input="updateValue"
      @focus="hideInputError"
      class="form-control"
      id="body"
      maxlength="10000"
      autocomplete="off"
      rows="7"
      required
    >
    </textarea>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import AppButton from "../../shared/AppButton.vue";
import Markdown from "vue3-markdown-it";

const props = defineProps({
  modelValue: {
    type: String,
    default: "",
  },
  postBodyError: {
    type: String,
    default: "",
  },
});

const postBodyData = reactive({
  isPreviewVisible: false,
  previewError: props.postBodyError,
});

const emit = defineEmits();

const hideInputError = () => {
  postBodyData.previewError = props.postBodyError;
};
const togglePreview = () => {
  if (props.modelValue != "") {
    postBodyData.isPreviewVisible = !postBodyData.isPreviewVisible;
  } else {
    postBodyData.previewError = "Nothing to preview";
  }
};
const updateValue = (event) => {
  emit("update:modelValue", event.target.value);
};
</script>
