<template>
  <Layout pageTitle="common-absence-reason" pageIntro="Common absence reasons">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="2" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <section v-if="reactiveData.main_err != ''">
              <div class="row">
                <div class="col-md-12">
                  <HandleMsg
                    infotype="error"
                    customClass="form-responds-msg text-center"
                    :msg="reactiveData.main_err"
                  />
                </div>
              </div>
            </section>
            <section v-else>
              <!-- Add new Absence reason form -->
              <CommonAbsenceReasonsForm />
              <div class="form-wrapper mt-3">
                <h5 class="pb-2">Already saved reasons</h5>
                <hr class="m-0 mt-1 mb-3" />

                <div class="row">
                  <div class="col-md-6">
                    <input
                      v-model="search_word"
                      type="text"
                      class="form-control"
                      placeholder="Search reason..."
                      maxlength="255"
                      autocomplete="off"
                      @keypress.enter.prevent
                    />
                    <!-- col-md-6 -->
                  </div>
                  <div class="col-md-6">
                    <OptionElementInput
                      :defaultOptionSelected="reactiveData.option_selected"
                      labelName="Sort:"
                      :allowSearch="false"
                      :labelPrepend="true"
                      arrType="obj"
                      :disabledInput="true"
                      :resultObj="option_select_arr"
                      @updateSelectedOptionInput="handleSortSelectOption"
                    />

                    <!-- col-md-6 -->
                  </div>
                  <div class="col-md-12">
                    <hr class="mt-3 mb-2" />
                  </div>
                  <!-- end row -->
                </div>
                <section v-if="reactiveData.data_length > 0">
                  <div
                    v-if="reactiveData.is_searching || reactiveData.is_sorting"
                    class="row"
                  >
                    <div class="col-md-12 pt-3">
                      <LoadingIndicator />
                    </div>
                    <!-- end row -->
                  </div>
                  <div v-else>
                    <div class="row">
                      <div class="col-md-12">
                        <span class="small">{{ returnTotalRecordsMsg() }}</span>
                      </div>
                    </div>
                    <div
                      v-for="(reason, index) in reactiveData.api_res"
                      class="row"
                      :key="index"
                    >
                      <div
                        :class="{
                          'col-md-12 data-detail-wrapper': true,
                          'data-detail-wrapper-active': returnIfInputIsActive(reason.id),
                        }"
                      >
                        <div
                          class="small text-danger"
                          v-if="showErrMsgIfNotEmpty(reason.id)"
                        >
                          {{ reactiveData.edit_delete_err }}
                        </div>
                        <div class="input-group">
                          <input
                            ref="dataInput"
                            :value="
                              returnIfInputIsActive(reason.id)
                                ? reactiveData.data_new_value
                                : reason.name
                            "
                            :type="returnIfInputIsActive(reason.id) ? 'text' : 'button'"
                            @input="handleInputChange"
                            @focus="hideCustomErrorOnFocus"
                            :class="{
                              'form-control data-input': true,
                              'data-input-active': returnIfInputIsActive(reason.id),
                            }"
                          />
                          <div class="input-group-append">
                            <span v-if="returnIfInputIsActive(reason.id)">
                              <!-- Okay button -->
                              <AppButton
                                customClass="mr-2"
                                btnStyle="success"
                                :btnFunc="
                                  () => handleDataUpdate(index, reason.id, reason.name)
                                "
                              >
                                <span v-if="returnIfDataIsEditing(reason.id)"
                                  >Processing....</span
                                >
                                <span v-else-if="returnIfDataEditsuccess(reason.id)">{{
                                  reactiveData.edit_delete_success
                                }}</span>
                                <span v-else><i class="fas fa-check"></i></span>
                              </AppButton>
                              <!-- Cancel button -->
                              <AppButton
                                btnStyle="warn"
                                :hideBtn="hideCancelBtn(reason.id)"
                                :btnFunc="handleCancelBtn"
                              >
                                <span><i class="fas fa-times"></i></span>
                              </AppButton>
                            </span>
                            <span v-else>
                              <!-- Edit button -->
                              <AppButton
                                btnStyle="primary2"
                                customClass="mr-2"
                                :hideBtn="
                                  returnIfDataIsDeleting(reason.id) ||
                                  returnIfDataIsDeleteSuccess(reason.id)
                                "
                                :btnFunc="
                                  () => handleEditBtn(index, reason.id, reason.name)
                                "
                              >
                                <span><i class="fas fa-edit"></i></span>
                              </AppButton>
                              <!-- Delete button -->
                              <AppButton
                                :btnStyle="
                                  returnIfDataIsDeleting(reason.id)
                                    ? 'secondary'
                                    : returnIfDataIsDeleteSuccess(reason.id)
                                    ? 'success'
                                    : 'danger'
                                "
                                :btnFunc="
                                  () => handleDeleteDataYes(reason.id, reason.name)
                                "
                              >
                                <span v-if="returnIfDataIsDeleting(reason.id)"
                                  >Processing...</span
                                >

                                <span
                                  v-else-if="returnIfDataIsDeleteSuccess(reason.id)"
                                  >{{ reactiveData.edit_delete_success }}</span
                                >
                                <span v-else><i class="fas fa-trash"></i></span>
                              </AppButton>
                            </span>
                            <!-- end append div-->
                          </div>
                          <!-- end form-group -->
                        </div>
                        <div class="row pl-2">
                          <div class="col-md-6">
                            <ul class="result-detail-ul pl-0">
                              <li>
                                Created at:
                                <span>{{ returnFormattedDate(reason.created_at) }}</span>
                              </li>
                              <li>
                                created by:
                                <span>{{
                                  returnCoWorkerFullName(
                                    reason.created_by_f,
                                    reason.created_by_l
                                  )
                                }}</span>
                              </li>
                            </ul>
                          </div>
                          <div class="col-md-6">
                            <ul class="result-detail-ul pl-0">
                              <li>
                                Updated on:
                                <span>{{
                                  reason.updated_by_f === null
                                    ? "---"
                                    : returnFormattedDate(reason.updated_at)
                                }}</span>
                              </li>

                              <li>
                                Updated by:
                                <span>{{
                                  reason.updated_by_f === null
                                    ? "---"
                                    : returnCoWorkerFullName(
                                        reason.updated_by_f,
                                        reason.updated_by_l
                                      )
                                }}</span>
                              </li>
                            </ul>
                          </div>
                          <!-- end row -->
                        </div>
                        <!-- end if searching or sorting -->
                      </div>
                    </div>
                    <!-- end row -->
                  </div>
                  <div v-show="reason_res?.next_page_url != null" class="row pt-3">
                    <div class="col-md-6 mx-auto">
                      <AppButton
                        customClass="primary-btn"
                        :btnFunc="handleLoadMoreResult"
                        :fullBtn="true"
                      >
                        <span v-if="reactiveData.is_paginating">
                          <LoadingIndicator loaderSize="small" :showBelowText="false" />
                        </span>
                        <span v-else> Load more </span>
                      </AppButton>
                    </div>

                    <!-- end row -->
                  </div>
                </section>
                <section v-else>
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <p>Sorry no saved reason found</p>
                    </div>
                    <!-- end row -->
                  </div>
                </section>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { reactive, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";
import CommonAbsenceReasonsForm from "./CommonAbsenceReasonsForm";
import HandleMsg from "../../shared/HandleMsg";
import OptionElementInput from "../../shared/OptionElementInput";
import AppButton from "../../shared/AppButton";
import LoadingIndicator from "../../shared/LoadingIndicator";
import {
  returnSortOptionArray,
  returnFormattedDate,
  returnCoWorkerFullName,
  scrollToTopOrBottomOfPage,
  removeItemFromArrOrObjByValue,
  returnSystemErrorMsg,
} from "../../helper/util";
import { debounce } from "lodash";
import axios from "../../api/axios";

const option_select_arr = returnSortOptionArray();
const search_word = ref("");
let dataInput = ref(null);

const props = defineProps({
  errors: Object,
  reason_res: {
    type: Object,
    default: {},
  },
  respondsMsg: {
    type: String,
    default: "",
  },
});

const reactiveData = reactive({
  api_res: props.reason_res?.data,
  data_length: props.reason_res?.data.length,
  current_records_on_page: props.reason_res?.data.length,
  total_records: props.reason_res?.total,
  main_err: props.errors?.fail == undefined ? "" : props.errors?.fail,
  option_selected: "Latest",
  is_searching: false,
  is_searching_complete: false,
  is_paginating: false,
  is_sorting: false,
  first_page_load: true,
  edit_delete_err: "",
  edit_delete_success: "",

  //EDIT
  data_new_value: "",
  data_old_value: "",
  data_being_edited_id: 0,
  show_ok_cancel_btn: false,
  is_editing: false,

  //Delete
  is_deleting: false,
  is_deleted: false,
});

const handleEditBtn = (index, data_id, data_value) => {
  reactiveData.data_being_edited_id = data_id;
  reactiveData.data_new_value = data_value;
  reactiveData.data_old_value = data_value;
  reactiveData.show_ok_cancel_btn = true;
  dataInput.value[index].focus();
};

const handleCancelBtn = () => {
  reactiveData.data_being_edited_id = 0;
  reactiveData.data_new_value = "";
  reactiveData.data_old_value = "";
  reactiveData.main_err = "";
  reactiveData.edit_delete_err = "";
  reactiveData.edit_delete_success = "";
  reactiveData.show_ok_cancel_btn = false;
  reactiveData.is_deleted = false;
};

const returnIfDataIsDeleting = (data_id) => {
  let deleting = false;
  if (reactiveData.is_deleting && reactiveData.data_being_edited_id == data_id) {
    deleting = true;
  }
  return deleting;
};

const returnIfDataIsDeleteSuccess = (data_id) => {
  let success = false;
  if (
    reactiveData.is_deleted &&
    reactiveData.edit_delete_success != "" &&
    reactiveData.data_being_edited_id == data_id
  ) {
    success = true;
  }
  return success;
};

const returnIfDataIsEditing = (data_id) => {
  let editing = false;
  if (reactiveData.is_editing && reactiveData.data_being_edited_id == data_id) {
    editing = true;
  }
  return editing;
};

const returnIfDataEditsuccess = (data_id) => {
  let success = false;
  if (
    reactiveData.edit_delete_success != "" &&
    !reactiveData.is_editing &&
    reactiveData.data_being_edited_id == data_id
  ) {
    success = true;
  }
  return success;
};

const showErrMsgIfNotEmpty = (data_id) => {
  let is_empty_msg = false;
  if (
    reactiveData.edit_delete_err != "" &&
    reactiveData.data_being_edited_id == data_id
  ) {
    is_empty_msg = true;
  }
  return is_empty_msg;
};

const returnIfInputIsActive = (data_id) => {
  let is_active = false;
  if (reactiveData.show_ok_cancel_btn && reactiveData.data_being_edited_id == data_id) {
    is_active = true;
  }
  return is_active;
};

const hideCancelBtn = (data_id) => {
  let cancel = false;
  if (
    reactiveData.edit_delete_success != "" &&
    reactiveData.data_being_edited_id == data_id
  ) {
    cancel = true;
  }
  return cancel;
};

const handleInputChange = (e) => {
  reactiveData.data_new_value = e.target.value;
};

const hideCustomErrorOnFocus = () => {
  if (reactiveData.main_err != "") {
    reactiveData.main_err = "";
  }

  if (reactiveData.edit_delete_err != "") {
    reactiveData.edit_delete_err = "";
  }
};

const assignDataFromAxiosApiCall = (is_paginate_result) => {
  reactiveData.data_length = props.reason_res?.data.length;
  reactiveData.total_records = props.reason_res?.total;
  //if paginate result, add else replace.
  if (is_paginate_result) {
    reactiveData.api_res = [...reactiveData.api_res, ...props.reason_res?.data];
    reactiveData.current_records_on_page =
      reactiveData.current_records_on_page + props.reason_res?.data.length;
  } else {
    reactiveData.api_res = props.reason_res?.data;
    reactiveData.current_records_on_page = props.reason_res?.data.length;
  }
};

const returnDataToBePost = () => {
  return {
    selected_sort_option: reactiveData.option_selected,
    reason: search_word.value,
    first_page_load: reactiveData.first_page_load,
  };
};

const handleLoadMoreResult = async () => {
  if (!reactiveData.is_searching) {
    if (props.reason_res?.next_page_url === null) {
      return;
    }
    reactiveData.first_page_load = false;

    router.post(props.reason_res?.next_page_url, returnDataToBePost(), {
      preserveState: true,
      preserveScroll: true,
      only: ["reason_res"],
      onStart: () => {
        reactiveData.is_paginating = true;
      },
      onFinish: () => {
        reactiveData.is_paginating = false;
      },

      onSuccess: () => {
        scrollToTopOrBottomOfPage("bottom");
        window.history.replaceState({}, "", props.reason_res?.path);
        assignDataFromAxiosApiCall(true);
      },
    });
  } // end if !reactiveData.is_searching
};

const returnTotalRecordsMsg = () => {
  let record_word = "record";

  if (reactiveData.total_records > 1) {
    record_word = "records";
  }
  return (
    reactiveData.current_records_on_page +
    " of " +
    reactiveData.total_records +
    " total " +
    record_word
  );
};

const makeApiCall = async () => {
  router.post("/absence/reasons", returnDataToBePost(), {
    onFinish: () => {
      if (reactiveData.is_searching) {
        reactiveData.is_searching = false;
      }
      if (reactiveData.is_sorting) {
        reactiveData.is_sorting = false;
      }
    },
    onSuccess: () => {
      assignDataFromAxiosApiCall(false);
      if (props.respondsMsg == "searching_or_sorting") {
        scrollToTopOrBottomOfPage("bottom");
        //console.log(props.respondsMsg);
      }
    },
  });
};

const handleSearchForm = () => {
  reactiveData.is_searching = true;
  reactiveData.first_page_load = false;
  reactiveData.current_records_on_page = 0;
  makeApiCall();
};

const handleSortSelectOption = (selected_sort_option) => {
  reactiveData.is_sorting = true;
  reactiveData.first_page_load = false;
  reactiveData.option_selected = selected_sort_option;
  reactiveData.current_records_on_page = 0;
  makeApiCall();
};

//HANDLE UPDATE OK BTN

const handleDataUpdate = (index, data_id) => {
  let abort = false;
  if (reactiveData.data_new_value == "") {
    abort = true;
    reactiveData.edit_delete_err = "Please enter a reason";
  }
  if (reactiveData.data_old_value == reactiveData.data_new_value) {
    abort = true;
    reactiveData.edit_delete_err = "Please make changes before saving thanks";
  }

  if (!abort) {
    //save data
    reactiveData.is_editing = true;
    setTimeout(async () => {
      try {
        const res = await axios.post("/absence/update-reason", {
          data_id: data_id,
          data_new_value: reactiveData.data_new_value,
          data_old_value: reactiveData.data_old_value,
        });
        if (res.data?.error != "") {
          reactiveData.edit_delete_err = res.data?.error;
        } else {
          reactiveData.edit_delete_success = "Success";
          setTimeout(() => {
            reactiveData.api_res[index].name = reactiveData.data_new_value;
            reactiveData.api_res[index].updated_by_f = res.data?.updated_by_f;
            reactiveData.api_res[index].updated_by_l = res.data?.updated_by_l;
            reactiveData.api_res[index].updated_at = res.data?.updated_on;
            reactiveData.edit_delete_success = "";
            reactiveData.data_being_edited_id = 0;
            reactiveData.show_ok_cancel_btn = false;
          }, 300);
        }
      } catch (err) {
        reactiveData.edit_delete_err = returnSystemErrorMsg();
      } finally {
        reactiveData.is_editing = false;
      }
    }, 500);
  }
};

//HANDLE DELETE BTN
const handleDeleteDataYes = (data_id, data_name) => {
  reactiveData.edit_delete_err = "";

  if (window.confirm(`Delete ${data_name}? please note this can not be undone.`)) {
    reactiveData.is_deleted = false;
    reactiveData.is_deleting = true;
    reactiveData.data_being_edited_id = data_id;

    setTimeout(async () => {
      try {
        const res = await axios.post("/absence/delete-reason", {
          data_id: data_id,
        });
        //res.data.outcome can be boolean or error message
        if (res?.data?.error == "") {
          //set success msg
          reactiveData.edit_delete_success = "Success";
          reactiveData.is_deleted = true;
          setTimeout(() => {
            reactiveData.api_res = removeItemFromArrOrObjByValue(
              data_id,
              reactiveData.api_res,
              "id",
              "obj"
            );
            reactiveData.total_records = reactiveData.total_records - 1;
            reactiveData.current_records_on_page =
              reactiveData.current_records_on_page - 1;
          }, 300);
        } else {
          //Set error meg
          reactiveData.edit_delete_err = res?.data?.error; //console.log("PHONE ERROR =>", res.data.outcome);
        }
      } catch (err) {
        reactiveData.edit_delete_err = returnSystemErrorMsg();
        //console.log("ERR =>", err);
      } finally {
        reactiveData.is_deleting = false;
      }
    }, 500);
  } // end window confirm
};

//Watch the search input value for changes.
watch(
  search_word,
  debounce(() => {
    handleSearchForm();
  }, 400)
);
</script>
