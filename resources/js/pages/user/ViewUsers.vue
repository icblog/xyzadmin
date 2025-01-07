<template>
  <Layout pageTitle="view-users" pageIntro="View users">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="0" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <section v-if="view_users_data.custom_err != ''">
              <div class="row">
                <div class="col-md-12">
                  <HandleMsg
                    infotype="error"
                    customClass="form-responds-msg text-center"
                    :msg="view_users_data.custom_err"
                  />
                </div>
              </div>
            </section>
            <section v-else>
              <div class="row">
                <div class="col-md-6">
                  <input
                    v-model="search_word"
                    type="text"
                    class="form-control"
                    placeholder="Search user..."
                    maxlength="255"
                    autocomplete="off"
                    @keypress.enter.prevent
                  />
                  <!-- col-md-6 -->
                </div>
                <div class="col-md-6">
                  <OptionElementInput
                    :defaultOptionSelected="view_users_data.option_selected"
                    labelName="Sort:"
                    :allowSearch="false"
                    :labelPrepend="true"
                    arrType="arr"
                    :disabledInput="true"
                    :resultObj="option_select_arr"
                    @updateSelectedOptionInput="handleSortSelectOption"
                  />

                  <!-- col-md-6 -->
                </div>
                <div class="col-md-12">
                  <hr class="mt-3 mb-1" />
                </div>
                <!-- end row -->
              </div>
              <div
                v-if="view_users_data.is_searching || view_users_data.is_sorting"
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
                    <hr class="mt-1 mb-3" />
                  </div>
                </div>
                <div
                  v-show="view_users_data.data_length > 0"
                  v-for="(user, index) in view_users_data.view_user_api_res"
                  class="mb-3 box-shadow"
                  :key="index"
                >
                  <div class="row">
                    <div v-show="returnIfDeleteUserErr(user.id)" class="col-md-12">
                      <p class="p-0 m-0 small text-danger">
                        {{ view_users_data.delete_error }}
                      </p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-5">
                      <ul class="result-detail-ul">
                        <li>
                          Full name:
                          <span>{{
                            returnCoWorkerFullName(user.fname, user.lname)
                          }}</span>
                        </li>

                        <li>
                          Username:
                          <span>{{ user.username }}</span>
                        </li>
                        <li>
                          Email:
                          <span>{{ user.email }}</span>
                        </li>
                        <li>
                          Phone:
                          <span>{{ user.phone }}</span>
                        </li>

                        <li>
                          {{ user.is_depart_or_comp == 0 ? "Department:" : "Company:" }}

                          <span>{{ user.department_name }}</span>
                        </li>

                        <li>
                          Joined on:
                          <span>{{ returnFormattedDate(user.created_at) }}</span>
                        </li>
                      </ul>
                    </div>
                    <div class="col-5">
                      <ul class="result-detail-ul">
                        <li>
                          Ic-admin app access:
                          <span>{{ user.xyz_app_access === 0 ? "No" : "Yes" }}</span>
                        </li>
                        <li>
                          Leader:
                          <span>{{ user.is_leader === 0 ? "No" : "Yes" }}</span>
                        </li>
                        <li>
                          Role:
                          <span>{{ user.role === 0 ? "User" : "Admin" }}</span>
                        </li>
                        <li>
                          Badge id:
                          <span>{{ user.badge_id }}</span>
                        </li>
                        <li>
                          Locker:
                          <span class="locker-name-number">{{
                            user.locker_name === null ? "----" : user.locker_name
                          }}</span>
                        </li>
                        <li>
                          Last updated:
                          <span>{{ returnFormattedDate(user.updated_at) }}</span>
                        </li>
                      </ul>
                    </div>
                    <div class="col-2 pt-5">
                      <!-- start delete btn -->

                      <span v-show="$page.props.isAdmin">
                        <AppButton
                          :btnStyle="
                            returnIfDeleteUserIsDeleting(user.id)
                              ? 'secondary'
                              : returnIfDeleteUserSuccess(user.id)
                              ? 'success'
                              : 'danger'
                          "
                          :btnFunc="
                            () =>
                              handleDeleteUserBtn(
                                user.id,
                                returnCoWorkerFullName(user.fname, user.lname)
                              )
                          "
                        >
                          <span v-if="returnIfDeleteUserIsDeleting(user.id)"
                            >One sec...</span
                          >
                          <span v-else-if="returnIfDeleteUserSuccess(user.id)"
                            >Success</span
                          >
                          <span v-else>
                            <i class="fas fa-trash"></i>
                          </span>
                        </AppButton>
                      </span>
                      <!-- end delete btn -->
                      <span>
                        <AppLink
                          className="btn-primary btn no-border-radius ml-2"
                          linkUrl="/edit-user"
                        >
                          <span>
                            <i class="fas fa-edit"></i>
                          </span> </AppLink
                      ></span>
                    </div>

                    <!-- end row -->
                  </div>

                  <div class="pt-2">
                    <hr class="m-0" />
                  </div>
                </div>

                <div v-show="view_users_res?.next_page_url != null" class="row pt-3">
                  <div class="col-md-6 mx-auto">
                    <AppButton
                      customClass="primary-btn"
                      :btnFunc="handleLoadMoreResult"
                      :fullBtn="true"
                    >
                      <span v-if="view_users_data.is_paginating">
                        <LoadingIndicator loaderSize="small" :showBelowText="false" />
                      </span>
                      <span v-else> Load more </span>
                    </AppButton>
                  </div>

                  <!-- end row -->
                </div>
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
import HandleMsg from "../../shared/HandleMsg";
import OptionElementInput from "../../shared/OptionElementInput";
import AppButton from "../../shared/AppButton";
import AppLink from "../../shared/AppLink";
import LoadingIndicator from "../../shared/LoadingIndicator";

import {
  returnFormattedDate,
  returnCoWorkerFullName,
  scrollToTopOrBottomOfPage,
  returnSystemErrorMsg,
  removeItemFromArrOrObjByValue,
} from "../../helper/util";
import axios from "../../api/axios";
import { debounce } from "lodash";

const search_word = ref("");
const option_select_arr = ["Latest", "A-Z", "Z-A", "Department", "Company"];

const props = defineProps({
  errors: Object,
  view_users_res: {},
});

const view_users_data = reactive({
  view_user_api_res: props.view_users_res?.data,
  data_length: props.view_users_res?.data.length,
  total_records: props.view_users_res?.total,
  is_sorting: false,
  option_selected: option_select_arr[0],
  custom_err: props.errors?.fail == undefined ? "" : props.errors?.fail,
  is_searching: false,
  is_paginating: false,

  current_records_on_page: props.view_users_res?.data.length,

  //DELETE DATA
  user_being_deleted_id: 0,
  is_deleting: false,
  is_deleted: false,
  delete_success: "",
  delete_error: "",
});

//DELETE FUNCTIONS
const handleDeleteUserBtn = (user_id, full_name) => {
  view_users_data.delete_error = "";

  if (window.confirm(`Delete ${full_name}? please note this can not be undone.`)) {
    view_users_data.is_deleted = false;
    view_users_data.is_deleting = true;
    view_users_data.user_being_deleted_id = user_id;

    setTimeout(async () => {
      try {
        const res = await axios.post("/user/delete", {
          user_id: user_id,
        });
        //res.data.outcome can be boolean or error message
        if (res?.data?.error == "") {
          //set success msg
          view_users_data.delete_success = "Success";
          view_users_data.is_deleted = true;
          setTimeout(() => {
            view_users_data.view_user_api_res = removeItemFromArrOrObjByValue(
              user_id,
              view_users_data.view_user_api_res,
              "id",
              "obj"
            );
            view_users_data.total_records = view_users_data.total_records - 1;
            view_users_data.current_records_on_page =
              view_users_data.current_records_on_page - 1;
          }, 700);
        } else {
          //Set error meg
          view_users_data.delete_error = res?.data?.error; //console.log("PHONE ERROR =>", res.data.outcome);
        }
      } catch (err) {
        view_users_data.delete_error = returnSystemErrorMsg();
        //console.log("ERR =>", err);
      } finally {
        view_users_data.is_deleting = false;
      }
    }, 1500);
  } // end window confirm
};

const returnIfDeleteUserIsDeleting = (user_id) => {
  let deleting = false;
  if (view_users_data.is_deleting && view_users_data.user_being_deleted_id == user_id) {
    return (deleting = true);
  }

  return deleting;
};

const returnIfDeleteUserSuccess = (user_id) => {
  let success = false;
  if (
    view_users_data.is_deleted &&
    view_users_data.delete_success != "" &&
    view_users_data.user_being_deleted_id == user_id
  ) {
    success = true;
  }
  return success;
};

const returnIfDeleteUserErr = (user_id) => {
  let err = false;
  if (
    view_users_data.delete_error != "" &&
    view_users_data.user_being_deleted_id == user_id
  ) {
    err = true;
  }
  return err;
};

//VIEW FUNCTIONS

const assignDataFromAxiosApiCall = (isPagnateResult) => {
  view_users_data.data_length = props.view_users_res?.data.length;
  view_users_data.total_records = props.view_users_res?.total;
  //if paginate result, add else replace.
  if (isPagnateResult) {
    view_users_data.view_user_api_res = [
      ...view_users_data.view_user_api_res,
      ...props.view_users_res?.data,
    ];
    view_users_data.current_records_on_page =
      view_users_data.current_records_on_page + props.view_users_res?.data.length;
  } else {
    view_users_data.view_user_api_res = props.view_users_res?.data;
    view_users_data.current_records_on_page = props.view_users_res?.data.length;
  }
};

const returnDataToBePost = () => {
  return {
    option_selected: view_users_data.option_selected,
    searched_word: search_word.value,
  };
};

const handleLoadMoreResult = async () => {
  if (!view_users_data.is_searching) {
    if (props.view_users_res?.next_page_url === null) {
      return;
    }

    router.post(props.view_users_res?.next_page_url, returnDataToBePost(), {
      preserveState: true,
      preserveScroll: true,
      only: ["view_users_res"],
      onStart: () => {
        view_users_data.is_paginating = true;
      },
      onFinish: () => {
        view_users_data.is_paginating = false;
      },
      onSuccess: () => {
        window.history.replaceState({}, "", props.view_users_res?.path);
        scrollToTopOrBottomOfPage("bottom");
        assignDataFromAxiosApiCall(true);
      },
    });
  } // end if !view_users_data.is_searching
};

const returnTotalRecordsMsg = () => {
  let record_word = "record";

  if (view_users_data.total_records > 1) {
    record_word = "records";
  }
  return (
    view_users_data.current_records_on_page +
    " of " +
    view_users_data.total_records +
    " total " +
    record_word
  );
};

const getUserApiCall = async () => {
  router.post("/view-users", returnDataToBePost(), {
    onFinish: () => {
      if (view_users_data.is_searching) {
        view_users_data.is_searching = false;
      }
      if (view_users_data.is_sorting) {
        view_users_data.is_sorting = false;
      }
    },
    onSuccess: () => {
      assignDataFromAxiosApiCall(false);
    },
  });
};

const handleSearchForm = () => {
  view_users_data.is_searching = true;
  view_users_data.current_records_on_page = 0;
  view_users_data.option_selected = option_select_arr[0];
  getUserApiCall();
};

const handleSortSelectOption = (selected_sort_option) => {
  view_users_data.is_sorting = true;
  view_users_data.option_selected = selected_sort_option;
  view_users_data.current_records_on_page = 0;
  getUserApiCall();
};

//Watch the search input value for changes.
watch(
  search_word,
  debounce(() => {
    handleSearchForm();
  }, 400)
);
</script>
