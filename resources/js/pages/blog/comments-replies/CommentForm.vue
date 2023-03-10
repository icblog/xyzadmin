<template>
  <section v-if="$page.props.isLoggedIn">
    <section v-if="newCommentFormData.isFormProcessing">
      <LoadingIndicator />
    </section>
    <section v-if="!newCommentFormData.isFormProcessing && !previousUserCommentResult">
      <form class="comment-form" @submit.prevent="() => handleCommentFormSubmit()">
        <label class="form-label" for="comment">
          <h5 v-show="newCommentFormData.newFormSuccessMsg == ''">Add Comment</h5>
          <span v-if="newCommentFormData.newFormErrMsg != ''" class="text-danger small">{{
            newCommentFormData.newFormErrMsg
          }}</span>
          <span
            v-else-if="newCommentFormData.newFormSuccessMsg != ''"
            class="text-success"
            >{{ newCommentFormData.newFormSuccessMsg }}</span
          >
        </label>

        <div
          v-show="newCommentFormData.newFormSuccessMsg == ''"
          class="comment-input-wrapper"
        >
          <div>
            <textarea
              rows="1"
              cols="100"
              v-model="newCommentFormData.comment"
              class="form-control"
              maxlength="2000"
              autocomplete="off"
              id="comment"
              @focus="hideFormErr"
            >
            </textarea>
          </div>
          <input
            v-model="newCommentFormData.myhouse"
            type="text"
            maxlength="2"
            name="myhouse"
            class="not_in_my_house"
          />
          <div class="text-right pt-1">
            <AppButton btnType="submit" btnStyle="secondary">Save</AppButton>
          </div>
        </div>
      </form>
    </section>
  </section>
  <span v-else>
    <AppLink linkUrl="/login">Login to comment</AppLink>
  </span>
</template>

<script setup>
import { reactive } from "vue";
import { usePage } from "@inertiajs/vue3";
import AppButton from "../../../shared/AppButton.vue";
import LoadingIndicator from "../../../shared/LoadingIndicator.vue";
import AppLink from "../../../shared/AppLink.vue";
import axios from "../../../api/axios";
import { returnSystemErrorMsg, toSqlDatetime } from "../../../helper/util";

// const emit = defineEmits(["setHasParentCommentEditBtnClickedToFalse"]);
const props = defineProps({
  requestSlug: {
    type: String,
    default: "",
  },

  postId: {
    type: Number,
    default: 0,
  },
  previousUserCommentResult: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["updateCommentResult"]);

const newCommentFormData = reactive({
  isFormProcessing: false,
  newFormErrMsg: "",
  newFormSuccessMsg: "",
  comment: "",
  myhouse: "",
});

const hideFormErr = () => {
  newCommentFormData.newFormErrMsg = "";
};

const handleCommentFormSubmit = () => {
  let abort = false;

  if (newCommentFormData.comment == "") {
    abort = true;
    newCommentFormData.newFormErrMsg = "*Please fill in your comment";
  }

  if (!abort) {
    //Post the form
    newCommentFormData.isFormProcessing = true;
    setTimeout(async () => {
      try {
        const res = await axios.post("/blog/save-comment", {
          comment: newCommentFormData.comment,
          myhouse: newCommentFormData.myhouse,
          postId: props.postId,
          saveOrUpdateOrDelete: "save",
        });

        if (res?.data?.outcome === true) {
          newCommentFormData.newFormSuccessMsg =
            "Your comment has been successfully saved, thank you";
          setTimeout(() => {
            res.data.res.reply_total = 0;
            res.data.res.body = newCommentFormData.comment;
            res.data.res.created_at = toSqlDatetime(new Date());
            res.data.res.commented_by = usePage().props?.username;
            newCommentFormData.newFormSuccessMsg = "";
            newCommentFormData.comment = "";
            //ask parent to update comment results
            emit("updateCommentResult", res.data.res);
          }, 1500);
        } else {
          //console.log(res);
          newCommentFormData.newFormErrMsg = res?.data?.outcome[0];
        }
      } catch (err) {
        console.log(err);
        newCommentFormData.newFormErrMsg = returnSystemErrorMsg();
      } finally {
        newCommentFormData.isFormProcessing = false;
      }
    }, 1000);
  }
};
</script>
