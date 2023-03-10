<template>
  <section
    class="pt-2 pb-2"
    v-if="isFormProcessing && commentOrReplyToBeEditId == commentOrReplyEntry?.id"
  >
    <LoadingIndicator loaderSize="small" loaderPSizeClassName="small" />
  </section>
  <section v-else>
    <div class="existing-comment-or-reply-form input-group">
      <span
        class="existing-comment-or-reply-form-input-span-wrapper"
        v-show="!editData.hasEditOrRelpyBtnBeenClicked"
      >
        <span
          v-show="commentOrReplyEntry.replied_to != null"
          :class="{
            'existing-comment-or-reply-form-input-span': true,
          }"
          >@{{ commentOrReplyEntry.replied_to }}
        </span>
      </span>

      <input
        ref="commentOrReplyEntryInputRef"
        v-model="editData.commentOrReplyEntryBody"
        :type="
          commentOrReplyToBeEditId == commentOrReplyEntry?.id &&
          editData.hasEditOrRelpyBtnBeenClicked
            ? 'text'
            : 'button'
        "
        :class="{
          'form-control existing-comment-or-reply-form-input': true,
          'existing-comment-or-reply-input-active':
            commentOrReplyToBeEditId == commentOrReplyEntry?.id &&
            editData.hasEditOrRelpyBtnBeenClicked,
        }"
        @focus="hideFormCustomErr"
      />
      <div class="input-group-append">
        <span
          :class="
            commentOrReplyToBeEditId == commentOrReplyEntry?.id
              ? 'existing-comment-or-reply-ellipse-btn-active'
              : 'existing-comment-or-reply-ellipse-btn'
          "
        >
          <AppButtonVue :btnFunc="() => handleEllipsisBtn(commentOrReplyEntry?.id)">
            <span v-if="commentOrReplyToBeEditId == commentOrReplyEntry?.id">
              <i class="fa fa-times"></i>
            </span>
            <span v-else>
              <i class="fa fa-ellipsis-v"></i>
            </span>
          </AppButtonVue>
        </span>

        <div class="existing-comment-or-reply-btn-wrapper">
          <div
            :class="{
              'existing-comment-or-reply-action-btn-wrapper': true,
              'existing-comment-or-reply-btn-wrapper-active':
                commentOrReplyToBeEditId == commentOrReplyEntry?.id,
            }"
          >
            <section>
              <ul v-show="!editData.hasEditOrRelpyBtnBeenClicked">
                <!-- IF user is looged in and the comment belongs to them, show edit and delete button -->
                <span
                  v-if="
                    commentOrReplyEntry?.replied_by == usePage().props?.username ||
                    commentOrReplyEntry?.commented_by == usePage().props?.username
                  "
                >
                  <li>
                    <AppButtonVue
                      customClass="small"
                      :btnFunc="
                        () => handleEditOrReplyBtn('edit', commentOrReplyEntry?.id)
                      "
                      ><i class="fa fa-edit"></i> Edit</AppButtonVue
                    >
                  </li>
                  <li>
                    <AppButtonVue
                      customClass="small"
                      :btnFunc="handleCommentOrReplayDelete"
                      ><i class="fa fa-trash"></i> Delete</AppButtonVue
                    >
                  </li>
                </span>
                <!-- Else show reply and report button -->
                <span v-else>
                  <li>
                    <AppButtonVue
                      customClass="small"
                      :btnFunc="
                        () => handleEditOrReplyBtn('reply', commentOrReplyEntry?.id)
                      "
                      ><i class="fa fa-reply"></i> Reply</AppButtonVue
                    >
                  </li>
                  <li>
                    <AppButtonVue customClass="small"
                      ><i class="fa fa-flag"></i> Report</AppButtonVue
                    >
                  </li>
                </span>
              </ul>

              <ul v-show="editData.hasEditOrRelpyBtnBeenClicked">
                <li>
                  <AppButtonVue customClass="small" :btnFunc="() => handleSaveBtn()"
                    ><i class="fa fa-check"></i> Save</AppButtonVue
                  >
                </li>
                <li>
                  <AppButtonVue customClass="small" :btnFunc="() => handleCancelBtn()"
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
import { reactive, ref, watch } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import AppButtonVue from "../../../shared/AppButton.vue";
import LoadingIndicator from "../../../shared/LoadingIndicator.vue";
import { focusOnFirstInput, moveCursorToTextEnd } from "../../../helper/util";

let commentOrReplyEntryInputRef = ref(null);

const props = defineProps({
  commentOrReplyEntry: {
    type: Object,
    default: {},
  },
  commentOrReplyToBeEditId: {
    type: Number,
    default: 0,
  },

  commentOrReplyEntryIndex: {
    type: Number,
    default: "",
  },
  isCommentOrReplyEntryUpdatedSuccess: {
    type: Boolean,
    default: false,
  },

  isFormProcessing: {
    type: Boolean,
    default: false,
  },
  commentOrReplyEntryParentName: {
    type: String,
    default: "",
  },

  //IF PARENT IS REPLIES USE THESE PROPS ALSO.

  mainCommentId: {
    type: Number,
    default: 0,
  },

  totalCommentReplies: {
    type: Number,
    default: 0,
  },
});

const editData = reactive({
  commentOrReplyEntryBody: props.commentOrReplyEntry?.body,
  oldCommentOrReplyEntryBody: props.commentOrReplyEntry?.body,
  hasEditOrRelpyBtnBeenClicked: false,
  saveUpdateOrDelete: "",
});

const emit = defineEmits([
  "handleUpdate",
  "handleDelete",
  "hideErrors",
  "updateCommentTobEditedId",
  "checkIfUserHasAlreadyReply",
]);

const handleSaveBtn = () => {
  let dataToEmit = {};

  dataToEmit.updateOrDelete = editData.saveUpdateOrDelete;
  dataToEmit.entryIndex = props.commentOrReplyEntryIndex;

  if (props.commentOrReplyEntryParentName == "comment") {
    dataToEmit.oldCommentMsg = editData.oldCommentOrReplyEntryBody;
    dataToEmit.newCommentMsg = editData.commentOrReplyEntryBody;
    dataToEmit.commentId = props.commentOrReplyToBeEditId;
  } else if (props.commentOrReplyEntryParentName == "reply") {
    dataToEmit.oldReplyMsg = editData.oldCommentOrReplyEntryBody;
    dataToEmit.newReplyMsg = editData.commentOrReplyEntryBody;
    dataToEmit.replyId = props.commentOrReplyToBeEditId;
    dataToEmit.mainCommentId = props.mainCommentId;
    dataToEmit.totalCommentReplies = props.totalCommentReplies;
  } else {
    return;
  }
  if (editData.saveUpdateOrDelete == "update") {
    emit("handleUpdate", dataToEmit);
  }
};

const handleCommentOrReplayDelete = () => {
  let dataToEmit = {};
  dataToEmit.updateOrDelete = "delete";

  if (props.commentOrReplyEntryParentName == "comment") {
    dataToEmit.oldCommentMsg = "";
    dataToEmit.newCommentMsg = "";
    dataToEmit.commentId = props.commentOrReplyToBeEditId;
    dataToEmit.entryIndex = props.commentOrReplyEntryIndex;
    dataToEmit.totalCommentReplies = props.totalCommentReplies;
  } else if (props.commentOrReplyEntryParentName == "reply") {
    dataToEmit.oldReplyMsg = "";
    dataToEmit.newReplyMsg = "";
    dataToEmit.replyId = props.commentOrReplyToBeEditId;
    dataToEmit.entryIndex = props.commentOrReplyEntryIndex;
    dataToEmit.mainCommentId = props.mainCommentId;
    dataToEmit.totalCommentReplies = props.totalCommentReplies;
  } else {
    return;
  }
  emit("handleDelete", dataToEmit);
};

const handleEllipsisBtn = (commentOrReplyEntryId) => {
  //alert(editData.commentOrReplyToBeEditId);

  if (props.commentOrReplyToBeEditId == commentOrReplyEntryId) {
    handleCancelBtn();
  } else {
    emit("updateCommentTobEditedId", commentOrReplyEntryId);
  }
};

const handleEditOrReplyBtn = (action, commentOrReplyEntryId) => {
  //check if user is loggedin and if not redirect to login page
  if (!usePage().props.isLoggedIn) {
    router.visit("/login", { method: "get" });
    return;
  } else {
    if (action == "reply") {
      //Emit reply fuction from parent

      emit("checkIfUserHasAlreadyReply", commentOrReplyEntryId);
    } else {
      editData.saveUpdateOrDelete = "update";

      if (commentOrReplyEntryInputRef.value != null) {
        moveCursorToTextEnd(
          commentOrReplyEntryInputRef.value,
          editData.commentOrReplyEntryBody
        );
        focusOnFirstInput(commentOrReplyEntryInputRef);
      }
      editData.hasEditOrRelpyBtnBeenClicked = true;
      emit("updateCommentTobEditedId", commentOrReplyEntryId);
    }
  }
};

const handleCancelBtn = (setcommentOrReplyEntryBodyToOld = true) => {
  editData.hasEditOrRelpyBtnBeenClicked = false;
  editData.saveUpdateOrDelete = "";
  if (setcommentOrReplyEntryBodyToOld) {
    editData.commentOrReplyEntryBody = editData.oldCommentOrReplyEntryBody;
  }

  emit("updateCommentTobEditedId", 0);
  hideFormCustomErr();
};

const hideFormCustomErr = () => {
  emit("hideErrors");
};

watch(
  () => props.isCommentOrReplyEntryUpdatedSuccess,
  (newValue, oldValue) => {
    if (newValue) {
      editData.oldCommentOrReplyEntryBody = editData.commentOrReplyEntryBody;
      handleCancelBtn(false);
    }
  }
);
</script>
