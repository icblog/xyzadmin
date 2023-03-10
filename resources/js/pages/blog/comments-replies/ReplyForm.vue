<template>
  <section class="pt-2 pb-2" v-if="isFormProcessing">
    <LoadingIndicator loaderSize="small" loaderPSizeClassName="small" />
  </section>

  <section class="reply-wrapper" v-else>
    <div class="small reply-body-wrapper">{{ commentOrReplyBody }}</div>
    <div class="existing-comment-or-reply-form input-group">
      <input
        ref="replyInputRef"
        v-model="replyData.replyBody"
        type="text"
        class="form-control existing-comment-or-reply-form-input existing-comment-or-reply-input-active"
        @focus="hideFormCustomErr"
      />
      <div class="input-group-append">
        <span class="existing-comment-or-reply-ellipse-btn-active">
          <AppButtonVue :btnFunc="() => handleCloseOrCancelReplyBtn()">
            <span>
              <i class="fa fa-times"></i>
            </span>
          </AppButtonVue>
        </span>

        <div class="existing-comment-or-reply-btn-wrapper">
          <div
            class="existing-comment-or-reply-action-btn-wrapper existing-comment-or-reply-btn-wrapper-active"
          >
            <section>
              <ul>
                <li>
                  <AppButtonVue customClass="small" :btnFunc="() => handleSaveReplyBtn()"
                    ><i class="fa fa-check"></i> Save</AppButtonVue
                  >
                </li>
                <li>
                  <AppButtonVue
                    customClass="small"
                    :btnFunc="() => handleCloseOrCancelReplyBtn()"
                    ><i class="fa fa-times"></i> Cancel</AppButtonVue
                  >
                </li>
              </ul>
            </section>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref, onMounted, watch } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import AppButtonVue from "../../../shared/AppButton.vue";
import LoadingIndicator from "../../../shared/LoadingIndicator.vue";
import { focusOnFirstInput } from "../../../helper/util";

let replyInputRef = ref(null);

const props = defineProps({
  commentOrReplyIndex: {
    type: Number,
    default: 0,
  },
  commentOrReplyBody: {
    type: String,
    default: "",
  },

  isFormProcessing: {
    type: Boolean,
    default: false,
  },

  replyId: {
    type: Number,
    default: 0,
  },
commentId: {
    type: Number,
    default: 0,
  },

  totalCommentReplies: {
    type: Number,
    default: 0,
  },

  replyToUsername: {
    type: String,
    default: "",
  },
  requestSlug: {
    type: String,
    default: "",
  },

  
});

const replyData = reactive({
  replyBody: "",
});

const emit = defineEmits(["updateAllowReplyId", "handleSaveReply","hideErrors"]);

const handleSaveReplyBtn = () => {
  let dataToEmit = {};
  dataToEmit.replyId = props.replyId;
  dataToEmit.replyBody = replyData.replyBody;
  dataToEmit.commentId = props.commentId;
  dataToEmit.totalCommentReplies = props.totalCommentReplies;
  dataToEmit.replyToUsername = props.replyToUsername;
  dataToEmit.commentOrReplyIndex = props.commentOrReplyIndex;
  emit("handleSaveReply", dataToEmit);
};

const handleCloseOrCancelReplyBtn = () => {
  emit("updateAllowReplyId", 0);
};

const hideFormCustomErr = () => {
  emit("hideErrors");
};

onMounted(() => {
  if (replyInputRef.value != null) {
    focusOnFirstInput(replyInputRef);
  }
});


</script>
