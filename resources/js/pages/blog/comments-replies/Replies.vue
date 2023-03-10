<template>
  <section v-if="commentEntry.reply_total > 0" class="replies-section-wrapper">
    <AppButton
      :customClassObj="{
        'comment-total-reply-btn': true,
        'comment-total-reply-btn-active':
          checkWhichCommentReplyBeingProcessed(commentEntry.id) &&
          repliesReactiveData.isRepliesWrapperShowing,
      }"
      :noBtnStyle="true"
      :btnFunc="() => handleFetchRepliesBtn(commentEntry.id)"
    >
      <i
        :class="
          checkWhichCommentReplyBeingProcessed(commentEntry.id) &&
          repliesReactiveData.isRepliesWrapperShowing
            ? 'fa fa-chevron-up'
            : 'fa fa-chevron-down'
        "
      ></i>
      {{ commentEntry.reply_total
      }}{{ commentEntry.reply_total > 1 ? " replies" : " reply" }}</AppButton
    >

    <div
      v-if="
        checkWhichCommentReplyBeingProcessed(commentEntry.id) &&
        repliesReactiveData.isRepliesWrapperShowing
      "
      class="comment-replies-wrapper"
    >
      <section v-show="repliesReactiveData.isFetchingReply">
        <LoadingIndicator loaderSize="small" loaderPSizeClassName="small" />
      </section>
      <div v-if="repliesReactiveData.repliesData?.length > 0">
        <div v-for="(replyEntry, index) in repliesReactiveData.repliesData" :key="index">
          <!-- Check if reply has been deleted -->
          <div v-show="!checkIfReplyIdIsDeleted(replyEntry.id)">
            <!-- Check if reply belongs to the comment id -->
            <div v-if="replyEntry.comment_id == commentEntry.id" class="mb-4">
              <form @submit.prevent>
                <div v-if="replyEntry.parent_id == 0" class="reply-parent-warpper">
                  <!-- Replies to comment goes here -->
                  <div
                    v-if="
                      repliesReactiveData.isReplyUpdatingOrdeleting &&
                      repliesReactiveData.replyTobeEditedId == replyEntry.id
                    "
                  >
                    <LoadingIndicator loaderSize="small" loaderPSizeClassName="small" />
                  </div>

                  <div
                    v-else-if="
                      (!repliesReactiveData.isReplyUpdatingOrdeleting &&
                        repliesReactiveData.replyTobeEditedId == replyEntry.id &&
                        repliesReactiveData.customSuccess != '') ||
                      repliesReactiveData.customErr != ''
                    "
                  >
                    <span
                      v-show="repliesReactiveData.customErr != ''"
                      class="text-danger small"
                      >{{ repliesReactiveData.customErr }}</span
                    >
                    <span
                      v-show="repliesReactiveData.customSuccess != ''"
                      class="text-success small"
                      >{{ repliesReactiveData.customSuccess }}</span
                    >
                  </div>
                  <div v-else>
                    <p class="comment-or-reply-detail-head">
                      <span class="bolded">{{ replyEntry.replied_by }} </span>
                      <span class="comment-or-reply-detail-date">
                        replied on {{ replyEntry.created_at }}</span
                      >
                    </p>
                    <section
                      v-if="repliesReactiveData.allowUserToReplyId == replyEntry.id"
                    >
                      <ReplyForm
                        @handleSaveReply="handleSaveReply"
                        @updateAllowReplyId="updateAllowUserToReplyId"
                        @hideErrors="hideCustomErr"
                        :commentOrReplyBody="replyEntry.body"
                        :replyId="replyEntry.id"
                        :totalCommentReplies="commentEntry.reply_total"
                        :commentId="commentEntry.id"
                        :replyToUsername="replyEntry.replied_by"
                        :commentOrReplyToBeEditId="repliesReactiveData.replyTobeEditedId"
                        :isFormProcessing="repliesReactiveData.isReplyUpdatingOrdeleting"
                        :commentOrReplyIndex="index"
                      />
                    </section>
                    <section v-else>
                      <EditForm
                        @hideErrors="hideCustomErr"
                        @handleUpdate="handleUpdateOrDeleteReply"
                        @handleDelete="handleUpdateOrDeleteReply"
                        @checkIfUserHasAlreadyReply="updateAllowUserToReplyId"
                        @updateCommentTobEditedId="updateReplyTobEditedId"
                        :mainCommentId="commentEntry.id"
                        :totalCommentReplies="commentEntry.reply_total"
                        :commentOrReplyEntry="replyEntry"
                        :commentOrReplyEntryIndex="index"
                        :commentOrReplyToBeEditId="repliesReactiveData.replyTobeEditedId"
                        :isCommentOrReplyEntryUpdatedSuccess="
                          repliesReactiveData.isReplyUpdatedSuccess
                        "
                        commentOrReplyEntryParentName="reply"
                      />
                    </section>
                  </div>
                </div>

                <div
                  v-for="(replyChildEntry, childIndex) in repliesReactiveData.repliesData"
                  :key="childIndex"
                >
                  <div v-show="!checkIfReplyIdIsDeleted(replyChildEntry.id)">
                    <div
                      v-if="replyEntry.id == replyChildEntry.parent_id"
                      class="reply-children-warpper"
                    >
                      <!-- Replies to replies goes here -->
                      <div
                        v-if="
                          repliesReactiveData.isReplyUpdatingOrdeleting &&
                          repliesReactiveData.replyTobeEditedId == replyChildEntry.id
                        "
                      >
                        <LoadingIndicator
                          loaderSize="small"
                          loaderPSizeClassName="small"
                        />
                      </div>

                      <div
                        v-else-if="
                          (!repliesReactiveData.isReplyUpdatingOrdeleting &&
                            repliesReactiveData.replyTobeEditedId == replyChildEntry.id &&
                            repliesReactiveData.customSuccess != '') ||
                          repliesReactiveData.customErr != ''
                        "
                      >
                        <span
                          v-show="repliesReactiveData.customErr != ''"
                          class="text-danger small"
                          >{{ repliesReactiveData.customErr }}</span
                        >
                        <span
                          v-show="repliesReactiveData.customSuccess != ''"
                          class="text-success small"
                          >{{ repliesReactiveData.customSuccess }}</span
                        >
                      </div>
                      <div v-else>
                        <p class="comment-or-reply-detail-head">
                          <span class="bolded">{{ replyChildEntry.replied_by }} </span>
                          <span class="comment-or-reply-detail-date">
                            replied on {{ replyChildEntry.created_at }}</span
                          >
                        </p>

                        <section
                          v-if="
                            repliesReactiveData.allowUserToReplyId == replyChildEntry.id
                          "
                        >
                          <ReplyForm
                            @handleSaveReply="handleSaveReply"
                            @updateAllowReplyId="updateAllowUserToReplyId"
                            @hideErrors="hideCustomErr"
                            :commentOrReplyBody="replyChildEntry.body"
                            :replyId="replyChildEntry.id"
                            :commentId="commentEntry.id"
                            :replyToUsername="replyChildEntry.replied_by"
                            :totalCommentReplies="commentEntry.reply_total"
                            :commentOrReplyToBeEditId="
                              repliesReactiveData.replyTobeEditedId
                            "
                            :isFormProcessing="
                              repliesReactiveData.isReplyUpdatingOrdeleting
                            "
                            :commentOrReplyIndex="childIndex"
                          />
                        </section>
                        <section v-else>
                          <EditForm
                            @hideErrors="hideCustomErr"
                            @handleUpdate="handleUpdateOrDeleteReply"
                            @handleDelete="handleUpdateOrDeleteReply"
                            @checkIfUserHasAlreadyReply="updateAllowUserToReplyId"
                            @updateCommentTobEditedId="updateReplyTobEditedId"
                            :mainCommentId="commentEntry.id"
                            :totalCommentReplies="commentEntry.reply_total"
                            :commentOrReplyEntry="replyChildEntry"
                            :commentOrReplyEntryIndex="childIndex"
                            :commentOrReplyToBeEditId="
                              repliesReactiveData.replyTobeEditedId
                            "
                            :isCommentOrReplyEntryUpdatedSuccess="
                              repliesReactiveData.isReplyUpdatedSuccess
                            "
                            commentOrReplyEntryParentName="reply"
                          />
                        </section>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive, watch } from "vue";
import EditForm from "./EditForm.vue";
import ReplyForm from "./ReplyForm.vue";
import AppButton from "../../../shared/AppButton.vue";
import LoadingIndicator from "../../../shared/LoadingIndicator.vue";

import {
  checkIfAvalueIncludesInArrOrObj,
  removeItemFromArrOrObjByValue,
  returnSystemErrorMsg,
} from "../../../helper/util";
import axios from "../../../api/axios";

const emit = defineEmits(["updateCommentTotalReply"]);

const props = defineProps({
  commentEntry: {
    type: Object,
    default: {},
  },

  commentEntryIndex: {
    type: Number,
    default: null,
  },
  isNewreplyBeenAdded: {
    type: Boolean,
    default: false,
  },
  isNewreplyBeenAddedCommentId: {
    type: Number,
    default: 0,
  },
});

const repliesReactiveData = reactive({
  customErr: "",
  customSuccess: "",
  repliesData: [],
  replyTobeEditedId: 0,
  allowUserToReplyId: 0,
  isReplyUpdatedSuccess: false,
  isReplyUpdatingOrdeleting: false,
  commentToBeProcessedIds: [],
  isFetchingReply: false,
  isCommentReplyFormShowing: false,
  isRepliesWrapperShowing: false,
  deletedReplyIds: [],
});

const handleUpdateOrDeleteReply = async ({
  updateOrDelete,
  oldReplyMsg,
  newReplyMsg,
  replyId,
  entryIndex,
  mainCommentId,
  totalCommentReplies,
}) => {
  let abort = false,
    msg = "Reply deleted successfully";

  if (updateOrDelete == "update") {
    if (newReplyMsg == "") {
      repliesReactiveData.customErr = "Please fill in your reply";
      abort = true;
    }

    if (oldReplyMsg == newReplyMsg) {
      repliesReactiveData.customErr = "Please make changes before saving";
      abort = true;
    }
    msg = "Reply updated successfully";
  } //End if updateOrDelete is update

  if (updateOrDelete == "delete") {
    if (window.confirm("Delete this reply ? please note this can not be undone")) {
      abort = false;
    } else {
      abort = true;
    }
  } //End if updateOrDelete is delete

  if (!abort) {
    repliesReactiveData.isReplyUpdatingOrdeleting = true;
    repliesReactiveData.isReplyUpdatedSuccess = false;
    try {
      const res = await axios.post("/blog/update-or-delete-reply", {
        replyId: replyId,
        replyMsg: newReplyMsg,
        commentId: mainCommentId,
        totalCommentReplies: totalCommentReplies,
        updateOrDelete: updateOrDelete,
      });

      if (res?.data?.outcome === true) {
        //success
        repliesReactiveData.customSuccess = msg;

        setTimeout(() => {
          repliesReactiveData.customSuccess = "";
          repliesReactiveData.replyTobeEditedId = 0;
          repliesReactiveData.allowUserToReplyId = 0;
          if (updateOrDelete == "update") {
            repliesReactiveData.repliesData[entryIndex].body = newReplyMsg;
            repliesReactiveData.isReplyUpdatedSuccess = true;
            repliesReactiveData.commentToBeProcessedIds = [];
            repliesReactiveData.isCommentReplyFormShowing = false;
            setTimeout(() => {
              repliesReactiveData.commentToBeProcessedIds.push(mainCommentId);
              repliesReactiveData.isRepliesWrapperShowing = true;
            }, 5);
          } else if (updateOrDelete == "delete") {
            repliesReactiveData.deletedReplyIds.push(replyId);
            emit("updateCommentTotalReply", {
              index: props.commentEntryIndex,
              action: "delete",
              newReplyData: {},
            });
          } else {
            repliesReactiveData.customErr = returnSystemErrorMsg();
          }
        }, 1000);
      } else {
        //Set error message

        repliesReactiveData.customErr = res?.data?.outcome[0];
      }
    } catch (err) {
      repliesReactiveData.customErr = returnSystemErrorMsg();
      console.log("UPDATE OR DELETE RPLIES REPLY ERR =>", err);
    } finally {
      repliesReactiveData.isReplyUpdatingOrdeleting = false;
    }
  } // End if abort is false
};

const handleSaveReply = ({
  replyId,
  replyBody,
  commentId,
  totalCommentReplies,
  replyToUsername,
}) => {
  let abort = false;

  if (replyBody == "") {
    abort = true;
    repliesReactiveData.customErr = "*Please fill in your reply";
  }

  if (!abort) {
    //Post the form
    repliesReactiveData.isReplyUpdatingOrdeleting = true;
    // repliesReactiveData.isCommentUpdatedSuccess = false;

    setTimeout(async () => {
      try {
        const res = await axios.post("/blog/save-comment-reply", {
          replyId: replyId,
          replyMsg: replyBody,
          commentId: commentId,
          totalCommentReplies: totalCommentReplies,
          action: "replies-reply",
          replyToUsername: replyToUsername,
        });

        if (res?.data?.outcome === true) {
          repliesReactiveData.customSuccess =
            "Your reply has been successfully saved, thank you";

          setTimeout(() => {
            repliesReactiveData.customSuccess = "";
            repliesReactiveData.replyTobeEditedId = 0;
            repliesReactiveData.allowUserToReplyId = 0;

            repliesReactiveData.repliesData = removeItemFromArrOrObjByValue(
              commentId,
              repliesReactiveData.repliesData,
              "comment_id",
              "obj"
            );
            fetchRepliesApiCall(commentId);
            emit("updateCommentTotalReply", {
              index: props.commentEntryIndex,
              action: "add",
              newReplyData: {},
            });
          }, 1000);
        } else {
          //console.log(res);
          repliesReactiveData.customErr = res?.data?.outcome[0];
        }
      } catch (err) {
        //console.log(err);
        repliesReactiveData.customErr = returnSystemErrorMsg();
      } finally {
        repliesReactiveData.isReplyUpdatingOrdeleting = false;
      }
    }, 1000);
  }
};
const hideCustomErr = () => {
  repliesReactiveData.customErr = "";
};

const updateReplyTobEditedId = (replyId) => {
  repliesReactiveData.replyTobeEditedId = replyId;
};

const updateAllowUserToReplyId = (replyId) => {
  if (replyId == 0) {
    repliesReactiveData.replyTobeEditedId = 0;
  }
  repliesReactiveData.allowUserToReplyId = replyId;
};

const removecommentToBeProcessedIdIfshowCommentReplyForm = (commentId) => {
  let idOutcome = checkIfAvalueIncludesInArrOrObj(
    commentId,
    repliesReactiveData.commentToBeProcessedIds,
    "commentId",
    "arr"
  );

  //If it does exist, remove it
  if (idOutcome) {
    repliesReactiveData.commentToBeProcessedIds = removeItemFromArrOrObjByValue(
      commentId,
      repliesReactiveData.commentToBeProcessedIds,
      "",
      "arr"
    );

    return true;
  } else {
    return false;
  }
};

const fetchRepliesApiCall = (commentId) => {
  repliesReactiveData.isFetchingReply = true;
  setTimeout(async () => {
    try {
      const res = await axios.post("/blog/fetch-comment-replies", {
        commentId: commentId,
      });

      if (res?.data?.error != "") {
        repliesReactiveData.customErr = res?.data?.error;
      } else {
        //Assign the new data
        repliesReactiveData.repliesData = [
          ...repliesReactiveData.repliesData,
          ...res?.data?.repliesData,
        ];
      }
    } catch (err) {
      repliesReactiveData.customErr = returnSystemErrorMsg();
      //console.log("Fetch replies ERR =>", err);
    } finally {
      repliesReactiveData.isFetchingReply = false;
    }
  }, 300);
};
const handleFetchRepliesBtn = (commentId) => {
  //Run this only if showCommentReplyForm is true

  if (repliesReactiveData.isCommentReplyFormShowing) {
    repliesReactiveData.commentToBeProcessedIds = [];
    repliesReactiveData.isCommentReplyFormShowing = false;
  } //end repliesReactiveData.isCommentReplyFormShowing

  // Check if commentId exist in repliesReactiveData.commentToBeProcessedIds array
  if (removecommentToBeProcessedIdIfshowCommentReplyForm(commentId)) {
    return;
  }
  //If it doesn't, push the commentId in the repliesReactiveData.commentToBeProcessedIds array

  repliesReactiveData.commentToBeProcessedIds.push(commentId);
  repliesReactiveData.isRepliesWrapperShowing = true;

  //Check if the commenteId can be found in the replyData array

  let outcome = checkIfAvalueIncludesInArrOrObj(
    commentId,
    repliesReactiveData.repliesData,
    "comment_id",
    "obj"
  );

  //If not found fetch a new reply by commit id from db
  if (!outcome) {
    fetchRepliesApiCall(commentId);
  }
};
const checkWhichCommentReplyBeingProcessed = (commentId) => {
  return checkIfAvalueIncludesInArrOrObj(
    commentId,
    repliesReactiveData.commentToBeProcessedIds,
    "commentId",
    "arr"
  );
};

const checkIfReplyIdIsDeleted = (replyEntryId) => {
  return checkIfAvalueIncludesInArrOrObj(
    replyEntryId,
    repliesReactiveData.deletedReplyIds,
    "",
    "arr"
  );
};

watch(
  () => props.isNewreplyBeenAdded,
  (newValue, oldValue) => {
    if (newValue) {
      repliesReactiveData.repliesData = removeItemFromArrOrObjByValue(
        props.isNewreplyBeenAddedCommentId,
        repliesReactiveData.repliesData,
        "comment_id",
        "obj"
      );
      fetchRepliesApiCall(props.isNewreplyBeenAddedCommentId);
    }
  }
);
</script>
