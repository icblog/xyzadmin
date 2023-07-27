<template>
  <section class="pt-5" ref="commentTopContainerRef">
    <hr />
    <!-- Comment form -->
    <CommentForm
      @updateCommentResult="updateMainCommentResult"
      :requestSlug="requestSlug"
      :postId="postId"
      :previousUserCommentResult="commentData.userAlredyCommentedResult"
    />
    <h5 class="pt-2">
      {{ commentData.totalComment
      }}{{ commentData.totalComment > 1 ? " Comments" : " Comment" }}
    </h5>
    <div class="comment-wrapper" v-if="commentData.postCommentResult.length > 0">
      <div v-for="(commentEntry, index) in commentData.postCommentResult" :key="index">
        <div v-show="!checkIsCommentIdDeleted(commentEntry.id)">
          <!-- commentData.commentToBeEditId == commentEntry.id -->

          <p class="comment-or-reply-detail-head">
            <span class="bolded">@{{ commentEntry.commented_by }} </span>
            <span class="comment-or-reply-detail-date">
              commented on {{ commentEntry.created_at }}</span
            >
          </p>
          <form @submit.prevent>
            <div v-show="commentData.commentToBeEditId == commentEntry.id">
              <span v-show="commentData.customErr != ''" class="text-danger small">{{
                commentData.customErr
              }}</span>
              <span v-show="commentData.customSuccess != ''" class="text-success small">{{
                commentData.customSuccess
              }}</span>
            </div>

            <section v-if="commentData.allowCommentReplyId == commentEntry.id">
              <ReplyForm
                @handleSaveReply="handleSaveCommentReply"
                @updateAllowReplyId="updateAllowCommentReplyId"
                @hideErrors="hideCustomErr"
                :commentOrReplyBody="commentEntry.body"
                :commentId="commentEntry.id"
                :totalCommentReplies="commentEntry.reply_total"
                :replyToUsername="commentEntry.commented_by"
                :commentOrReplyToBeEditId="commentData.commentToBeEditId"
                :isFormProcessing="commentData.isCommentUpdatingOrdeleting"
                :commentOrReplyIndex="index"
              />
            </section>
            <section v-else>
              <EditForm
                @checkIfUserHasAlreadyReply="checkIfUserhasAlreadyRepliedToComment"
                @handleUpdate="handleCommentUpdate"
                @handleDelete="handleCommentDelete"
                @updateCommentTobEditedId="updateCommentTobEditedId"
                @hideErrors="hideCustomErr"
                :commentOrReplyEntry="commentEntry"
                :commentOrReplyEntryIndex="index"
                :commentOrReplyToBeEditId="commentData.commentToBeEditId"
                :isFormProcessing="commentData.isCommentUpdatingOrdeleting"
                :isCommentOrReplyEntryUpdatedSuccess="commentData.isCommentUpdatedSuccess"
                commentOrReplyEntryParentName="comment"
              />
            </section>
          </form>
          <!-- Comment replies -->
          <Replies
            @updateCommentTotalReply="updateCommentTotalReply"
            :commentEntry="commentEntry"
            :commentEntryIndex="index"
            :isNewreplyBeenAdded="commentData.isNewreplyBeenAdded"
            :isNewreplyBeenAddedCommentId="commentData.isNewreplyBeenAddedCommentId"
          />
        </div>
      </div>
    </div>
    <div v-else>
      <HandleMsg
        infotype="info"
        :showHeading="false"
        :msg="'Be the first to comment on this post'"
      />
    </div>
  </section>
  <section>
    <!-- loadmore result here -->
    <span ref="loadMoreCommentIntersect" />
    <div v-if="commentData.isPaginating" class="text-center pt-4 pb-4">
      <LoadingIndicator />
    </div>
  </section>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import HandleMsg from "../../../shared/HandleMsg.vue";
import LoadingIndicator from "../../../shared/LoadingIndicator.vue";
import CommentForm from "./CommentForm.vue";
import EditForm from "./EditForm.vue";
import ReplyForm from "./ReplyForm.vue";
import Replies from "./Replies.vue";
import {
  checkIfAvalueIncludesInArrOrObj,
  removeItemFromArrOrObjByValue,
  scrollToElement,
  returnSystemErrorMsg,
} from "../../../helper/util";
import axios from "../../../api/axios";

let loadMoreCommentIntersect = ref(null),
  commentTopContainerRef = ref(null);

const props = defineProps({
  postId: {
    type: Number,
    default: 0,
  },
  requestSlug: {
    type: String,
    default: "",
  },

  postCommentResult: {
    type: Object,
    default: [],
  },

  previousUserCommentResult: {
    type: Boolean,
    default: false,
  },
});

const commentData = reactive({
  userAlredyCommentedResult: props.previousUserCommentResult,
  commentToBeEditId: 0,
  customErr: "",
  customSuccess: "",
  isCommentUpdatingOrdeleting: false,
  deletedCommentIds: [],
  isCommentUpdatedSuccess: false,
  totalComment: props.postCommentResult.total ? props.postCommentResult.total : 0,
  postCommentResult: props.postCommentResult.data ? props.postCommentResult.data : [],
  initialUrl: props.postCommentResult.path ? props.postCommentResult.path : "",
  isPaginating: false,
  previousUserComment: "",
  // Comment Reply reactive data
  allowCommentReplyId: "",
  isNewreplyBeenAdded: false,
  isNewreplyBeenAddedCommentId: 0,
  objArrOfHasUserAlreadyRepliedToComment: [],
  replyExistMsg:
    "Sorry You have already replied to this comment, click on replies button to view.",
});

const updateCommentTotalReply = ({ index, action, newReplyData }) => {
  if (action == "add") {
    commentData.postCommentResult[index].reply_total =
      commentData.postCommentResult[index].reply_total + 1;
    //commentData.postCommentResult[index] = newReplyData;
  } else {
    commentData.postCommentResult[index].reply_total =
      commentData.postCommentResult[index].reply_total - 1;
    commentData.objArrOfHasUserAlreadyRepliedToComment = removeItemFromArrOrObjByValue(
      usePage().props?.username,
      commentData.objArrOfHasUserAlreadyRepliedToComment,
      "username",
      "obj"
    );
  }
};

const updateMainCommentResult = (commentResult) => {
  commentData.postCommentResult = [...commentData.postCommentResult, commentResult];
  commentData.totalComment = commentData.totalComment + 1;
  commentData.userAlredyCommentedResult = true;
};
const updateAllowCommentReplyId = (commentId) => {
  if (commentId == 0) {
    commentData.commentToBeEditId = 0;
  }
  commentData.allowCommentReplyId = commentId;
};
const updateCommentTobEditedId = (commentId) => {
  commentData.commentToBeEditId = commentId;
};

const handleCommentUpdate = (emitedData) => {
  handleCommentUpdateOrDelete(emitedData);
};

const handleCommentDelete = (emitedData) => {
  handleCommentUpdateOrDelete(emitedData);
};

const checkIfUserhasAlreadyRepliedToComment = (commentId) => {
  commentData.isCommentUpdatingOrdeleting = true;
  //Check if the comment Id is in the already check array
  let abort = false,
    arr = commentData.objArrOfHasUserAlreadyRepliedToComment;
  if (arr.length > 0) {
    //properties
    //commentId, username, hasAlreadyReplied
    for (let i = 0; i < arr.length; i++) {
      if (
        arr[i].commentId == commentId &&
        arr[i].username == usePage().props?.username &&
        arr[i].hasAlreadyReplied
      ) {
        commentData.customErr = commentData.replyExistMsg;
        commentData.isCommentUpdatingOrdeleting = false;
        abort = true;
      } else if (
        arr[i].commentId == commentId &&
        arr[i].username == usePage().props?.username &&
        !arr[i].hasAlreadyReplied
      ) {
        commentData.isCommentUpdatingOrdeleting = false;
        abort = true;
        commentData.allowCommentReplyId = commentId;
      }
    } //End for loop
    // console.log(arr);
  } //End arr length > 0

  //If it is not in there, make api call to check it.

  if (!abort) {
    setTimeout(async () => {
      try {
        const res = await axios.post("/blog/check-reply-already-exit", {
          commentId: commentId,
        });

        if (res?.data?.error != "") {
          commentData.customErr = res?.data?.error;
        } else if (res?.data?.outcome) {
          //commentId, username, hasAlreadyReplied
          commentData.objArrOfHasUserAlreadyRepliedToComment.push({
            commentId: commentId,
            username: usePage().props?.username,
            hasAlreadyReplied: true,
          });
          commentData.customErr = commentData.replyExistMsg;
        } else {
          commentData.objArrOfHasUserAlreadyRepliedToComment.push({
            commentId: commentId,
            username: usePage().props?.username,
            hasAlreadyReplied: false,
          });
          commentData.allowCommentReplyId = commentId;
        }
      } catch (err) {
        commentData.customErr = returnSystemErrorMsg();
        //console.log("Check comment ERR =>", err);
      } finally {
        commentData.isCommentUpdatingOrdeleting = false;
      }
    }, 1000);
  }
};

const handleCommentUpdateOrDelete = ({
  updateOrDelete,
  oldCommentMsg,
  newCommentMsg,
  commentId,
  entryIndex,
  totalCommentReplies,
}) => {
  let abort = false;

  if (updateOrDelete != "delete") {
    if (newCommentMsg == "") {
      abort = true;
      commentData.customErr = "*Please fill in your comment";
    }

    if (!abort) {
      if (newCommentMsg == oldCommentMsg) {
        abort = true;
        commentData.customErr = "*Please make changes before saving";
      }
    }
  } else {
    if (
      window.confirm(
        "Delete this comment? please note this can not be undone and all replies to this comment will also be deleted"
      )
    ) {
      abort = false;
    } else {
      abort = true;
    }
  }

  if (!abort) {
    //Post the form
    commentData.isCommentUpdatingOrdeleting = true;
    commentData.isCommentUpdatedSuccess = false;

    setTimeout(async () => {
      try {
        const res = await axios.post("/blog/save-comment", {
          comment: newCommentMsg,
          postId: props.postId,
          saveOrUpdateOrDelete: updateOrDelete,
          commentId: commentId,
          totalCommentReplies: totalCommentReplies,
          myhouse: "",
        });

        if (res?.data?.outcome === true) {
          commentData.customSuccess =
            "Your comment has been successfully saved, thank you";

          if (updateOrDelete == "update") {
            commentData.customSuccess =
              "Your comment has been updated successfully, thank you";
          } else if (updateOrDelete == "delete") {
            commentData.customSuccess =
              "Your comment has been delete successfully, thank you";
          }

          setTimeout(() => {
            commentData.customSuccess = "";
            if (updateOrDelete == "update") {
              commentData.postCommentResult[entryIndex].body = newCommentMsg;
              commentData.isCommentUpdatedSuccess = true;
            }
            if (updateOrDelete == "delete") {
              commentData.totalComment = commentData.totalComment - 1;
              commentData.userAlredyCommentedResult = false;
              commentData.deletedCommentIds.push(commentId);
              scrollToElement(commentTopContainerRef);
            }
          }, 1500);
        } else {
          //console.log(res);
          commentData.customErr = res?.data?.outcome[0];
        }
      } catch (err) {
        //console.log(err);
        commentData.customErr = returnSystemErrorMsg();
      } finally {
        commentData.isCommentUpdatingOrdeleting = false;
      }
    }, 1000);
  }
};

const handleSaveCommentReply = ({
  replyId,
  replyBody,
  commentId,
  totalCommentReplies,
  replyToUsername,
  commentOrReplyIndex,
}) => {
  let abort = false;

  if (replyBody == "") {
    abort = true;
    commentData.customErr = "*Please fill in your reply";
  }

  if (!abort) {
    //Post the form
    commentData.isCommentUpdatingOrdeleting = true;
    commentData.isNewreplyBeenAdded = false;

    setTimeout(async () => {
      try {
        const res = await axios.post("/blog/save-comment-reply", {
          replyId: replyId,
          replyMsg: replyBody,
          commentId: commentId,
          totalCommentReplies: totalCommentReplies,
          action: "reply",
          replyToUsername: replyToUsername,
        });

        if (res?.data?.outcome === true) {
          commentData.customSuccess = "Your reply has been successfully saved, thank you";

          setTimeout(() => {
            let resArrObj = removeItemFromArrOrObjByValue(
              commentId,
              commentData.objArrOfHasUserAlreadyRepliedToComment,
              "commentId",
              "obj"
            );
            resArrObj.push({
              commentId: commentId,
              username: usePage().props?.username,
              hasAlreadyReplied: true,
            });

            commentData.customSuccess = "";
            commentData.objArrOfHasUserAlreadyRepliedToComment = resArrObj;
            commentData.commentToBeEditId = 0;
            commentData.allowCommentReplyId = 0;
            updateCommentTotalReply({
              index: commentOrReplyIndex,
              action: "add",
              newReplyData: {},
            });
            commentData.isNewreplyBeenAdded = true;
            commentData.isNewreplyBeenAddedCommentId = commentId;
          }, 1500);
        } else {
          //console.log(res);
          commentData.customErr = res?.data?.outcome[0];
        }
      } catch (err) {
        //console.log(err);
        commentData.customErr = returnSystemErrorMsg();
      } finally {
        commentData.isCommentUpdatingOrdeleting = false;
      }
    }, 1000);
  }
};

const loadMoreComments = () => {
  if (props.postCommentResult?.next_page_url === null) {
    return;
  }

  router.get(
    props.postCommentResult?.next_page_url,
    {},
    {
      preserveState: true,
      preserveScroll: true,
      only: ["postCommentResult"],
      onStart: () => {
        commentData.isPaginating = true;
      },
      onFinish: () => {
        commentData.isPaginating = false;
      },
      onSuccess: () => {
        window.history.replaceState({}, "", commentData.initialUrl);
        commentData.postCommentResult = [
          ...commentData.postCommentResult,
          ...props.postCommentResult?.data,
        ];
        // reactiveData.oldCategoriesData = reactiveData.categoriesResult;
      },
    }
  );
};

const hideCustomErr = () => {
  commentData.customErr = "";
};

const checkIsCommentIdDeleted = (commentId) => {
  return checkIfAvalueIncludesInArrOrObj(
    commentId,
    commentData.deletedCommentIds,
    "",
    "arr"
  );
};

onMounted(() => {
  const observer = new IntersectionObserver((entries) =>
    entries.forEach((entry) => entry.isIntersecting && loadMoreComments(), {
      rootMargin: "-100px 0px 0px 0px",
    })
  );

  observer.observe(loadMoreCommentIntersect.value);
});
</script>
