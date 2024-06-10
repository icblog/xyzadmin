<template>
  <Layout pageTitle="lockers" pageIntro="View lockers">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="5" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <section v-if="locker_data.custom_err != ''">
              <div class="row">
                <div class="col-md-12">
                  <HandleMsg
                    infotype="error"
                    customClass="form-responds-msg text-center"
                    :msg="locker_data.custom_err"
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
                    placeholder="Search locker..."
                    maxlength="255"
                    autocomplete="off"
                    @keypress.enter.prevent
                  />
                  <!-- col-md-6 -->
                </div>
                <div class="col-md-6">
                  <OptionElementInput
                    :defaultOptionSelected="locker_data.option_selected"
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
              <div v-if="locker_data.is_searching || locker_data.is_sorting" class="row">
                <div class="col-md-12 pt-3">
                  <LoadingIndicator />
                </div>
                <!-- end row -->
              </div>
              <!-- //Show results -->
              <div v-else>
                <div class="row">
                  <div class="col-md-12">
                    <span class="small">{{ returnTotalRecordsMsg() }}</span>
                    <hr class="mt-1 mb-3" />
                  </div>
                </div>
                <div
                  v-show="locker_data.data_length > 0"
                  v-for="(locker, index) in locker_data.view_locker_res"
                  class="mb-3"
                  :key="index"
                >
                  <div class="row box-shadow mb-4">
                    <div class="col-md-4">
                      <ul class="result-detail-ul pl-0">
                        <li>
                          Name/number:
                          <span class="locker-name-number">{{ locker.name }}</span>
                        </li>
                        <li>
                          Status:

                          <span
                            :class="{
                              'badge font-weight-bold no-border-radius': true,
                              'badge-warning': locker.locker_status == 2,
                              'badge-danger': locker.locker_status == 1,
                              'badge-success': locker.locker_status == 0,
                            }"
                          >
                            {{
                              locker.locker_status == 2
                                ? "Broken"
                                : locker.locker_status == 1
                                ? "Inuse"
                                : "Free"
                            }}</span
                          >
                        </li>
                        <li>
                          Belongs to:
                          <span>{{
                            locker.belongs_f == null
                              ? "---"
                              : returnCoWorkerFullName(locker.belongs_f, locker.belongs_l)
                          }}</span>
                        </li>
                        <li>
                          Comment:
                          <span>
                            {{ locker.comment == null ? "---" : locker.comment }}</span
                          >
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-4">
                      <ul class="result-detail-ul pl-0">
                        <li>
                          Added on:
                          <span>{{ returnFormattedDate(locker.created_at, true) }}</span>
                        </li>
                        <li>
                          Added by:
                          <span>{{
                            returnCoWorkerFullName(
                              locker.created_by_f,
                              locker.created_by_l
                            )
                          }}</span>
                        </li>
                        <li>
                          Updated on:
                          <span>{{
                            locker.updated_at === null
                              ? "---"
                              : returnFormattedDate(locker.updated_at, true)
                          }}</span>
                        </li>

                        <li>
                          Updated by:
                          <span>{{
                            locker.updated_by_f == null
                              ? "---"
                              : returnCoWorkerFullName(
                                  locker.updated_by_f,
                                  locker.updated_by_l
                                )
                          }}</span>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-4 pb-4 view-lockers-btn-wrapper">
                      <AppButton
                        :noBtnStyle="true"
                        :customClassObj="{
                          'mr-2 pb-1': true,
                          'primary-btn': locker.locker_status == 0,
                          'disabled-btn': locker.locker_status != 0,
                        }"
                        :btnDisabled="locker.locker_status != 0"
                        :btnFunc="() => handleModalOpen('assign', locker)"
                      >
                        <span><i class="fas fa-user-check"></i></span>
                      </AppButton>

                      <AppButton
                        customClass="btn-primary mt-3 mr-2 mb-4 pt-2 pb-2"
                        :btnFunc="() => handleModalOpen('edit', locker)"
                      >
                        <span>
                          <i class="fas fa-edit"></i>
                        </span>
                      </AppButton>
                      <AppButton
                        :noBtnStyle="true"
                        :customClassObj="{
                          'mt-3 mb-4': true,
                          'btn no-border-radius btn-danger pb-2 pt-2':
                            locker.locker_status == 0 || locker.locker_status == 2,
                          'disabled-btn': locker.locker_status == 1,
                        }"
                        :btnDisabled="locker.locker_status == 1"
                        :btnFunc="() => handleModalOpen('delete', locker)"
                      >
                        <span>
                          <i class="fas fa-trash"></i>
                        </span>
                      </AppButton>
                    </div>
                  </div>
                  <!-- end if result -->
                </div>
                <div
                  v-show="view_locker_prop_obj?.next_page_url != null"
                  class="row pt-3"
                >
                  <div class="col-md-6 mx-auto">
                    <AppButton
                      customClass="primary-btn"
                      :btnFunc="handleLoadMoreResult"
                      :fullBtn="true"
                    >
                      <span v-if="locker_data.is_paginating">
                        <LoadingIndicator loaderSize="small" :showBelowText="false" />
                      </span>
                      <span v-else> Load more </span>
                    </AppButton>
                  </div>

                  <!-- end row -->
                </div>
                <!-- end else -->
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL GOES HERE -->
    <Modal :showModal="locker_data.show_modal" :showCloseBtn="false">
      <template v-slot:c-modal-content>
        <section v-show="locker_data.is_assign_btn_clicked">
          <AssignLockerForm
            :locker="locker_data.locker_being_edited"
            @handleModalClose="handleModalClose"
          />
        </section>
        <section v-show="locker_data.is_edit_btn_clicked">
          <EditLockerForm
            :locker="locker_data.locker_being_edited"
            @handleModalClose="handleModalClose"
          />
        </section>
        <section v-show="locker_data.is_delete_btn_clicked">
          <DeleteLockerForm
            :locker="locker_data.locker_being_edited"
            @handleModalClose="handleModalClose"
          />
        </section>
      </template>
    </Modal>
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
import Modal from "../../shared/Modal";
import LoadingIndicator from "../../shared/LoadingIndicator";
import AssignLockerForm from "./AssignLockerForm";
import EditLockerForm from "./EditLockerForm";
import DeleteLockerForm from "./DeleteLockerForm";
import { debounce } from "lodash";
import {
  returnFormattedDate,
  returnCoWorkerFullName,
  scrollToTopOrBottomOfPage,
} from "../../helper/util";
const search_word = ref("");
const option_select_arr = ["All", "Free", "Inuse", "Broken"];
const props = defineProps({
  errors: Object,
  view_locker_prop_obj: {},
});

const locker_data = reactive({
  view_locker_res: props.view_locker_prop_obj?.data,
  data_length: props.view_locker_prop_obj?.data.length,
  total_records: props.view_locker_prop_obj?.total,
  is_sorting: false,
  is_sorting: false,
  option_selected: option_select_arr[0],
  custom_err: props.errors?.fail == undefined ? "" : props.errors?.fail,
  is_searching: false,
  is_paginating: false,
  current_records_on_page: props.view_locker_prop_obj?.data.length,
  //Edit data
  locker_being_edited: {},
  show_modal: false,
  is_assign_btn_clicked: false,
  is_edit_btn_clicked: false,
  edit_assign_title: "",
  is_delete_btn_clicked: false,
});

const handleModalOpen = (action, locker) => {
  locker_data.locker_being_edited = locker;
  locker_data.show_modal = true;
  if (action == "assign") {
    locker_data.edit_assign_title = `Assign locker ${locker.name}`;
    locker_data.is_assign_btn_clicked = true;
  } else if (action == "edit") {
    locker_data.edit_assign_title = `Edit locker ${locker.name}`;
    locker_data.is_edit_btn_clicked = true;
  } else if (action == "delete") {
    locker_data.edit_assign_title = `Delete locker ${locker.name}`;
    locker_data.is_delete_btn_clicked = true;
  }
};

const handleModalClose = () => {
  locker_data.locker_being_edited = {};
  locker_data.show_modal = false;
  locker_data.is_assign_btn_clicked = false;
  locker_data.is_edit_btn_clicked = false;
  locker_data.is_delete_btn_clicked = false;
};

const assignDataFromAxiosApiCall = (isPagnateResult) => {
  locker_data.data_length = props.view_locker_prop_obj?.data.length;
  locker_data.total_records = props.view_locker_prop_obj?.total;
  //if paginate result, add else replace.
  if (isPagnateResult) {
    locker_data.view_locker_res = [
      ...locker_data.view_locker_res,
      ...props.view_locker_prop_obj?.data,
    ];
    locker_data.current_records_on_page =
      locker_data.current_records_on_page + props.view_locker_prop_obj?.data.length;
  } else {
    locker_data.view_locker_res = props.view_locker_prop_obj?.data;
    locker_data.current_records_on_page = props.view_locker_prop_obj?.data.length;
  }
};

const returnTotalRecordsMsg = () => {
  let record_word = "record";

  if (locker_data.total_records > 1) {
    record_word = "records";
  }
  return (
    locker_data.current_records_on_page +
    " of " +
    locker_data.total_records +
    " total " +
    record_word
  );
};

const returnDataToBePost = () => {
  return {
    option_selected: locker_data.option_selected,
    searched_word: search_word.value,
  };
};

const getData = async () => {
  router.post("/lockers", returnDataToBePost(), {
    onFinish: () => {
      if (locker_data.is_searching) {
        locker_data.is_searching = false;
      }
      if (locker_data.is_sorting) {
        locker_data.is_sorting = false;
      }
    },
    onSuccess: () => {
      assignDataFromAxiosApiCall(false);
    },
  });
};

const handleSortSelectOption = async (selected_sort_option) => {
  locker_data.is_sorting = true;
  locker_data.option_selected = selected_sort_option;
  locker_data.current_records_on_page = 0;
  getData();
};

const handleSearchForm = () => {
  locker_data.is_searching = true;
  locker_data.current_records_on_page = 0;
  locker_data.option_selected = option_select_arr[0];
  getData();
};

const handleLoadMoreResult = async () => {
  if (!locker_data.is_searching) {
    if (props.view_locker_prop_obj?.next_page_url === null) {
      return;
    }

    router.post(props.view_locker_prop_obj?.next_page_url, returnDataToBePost(), {
      preserveState: true,
      preserveScroll: true,
      only: ["view_locker_prop_obj"],
      onStart: () => {
        locker_data.is_paginating = true;
      },
      onFinish: () => {
        locker_data.is_paginating = false;
      },
      onSuccess: () => {
        window.history.replaceState({}, "", props.view_locker_prop_obj?.path);
        scrollToTopOrBottomOfPage("bottom");
        assignDataFromAxiosApiCall(true);
      },
    });
  } // end if !locker_data.is_searching
};

//Watch the search input value for changes.
watch(
  search_word,
  debounce(() => {
    handleSearchForm();
  }, 400)
);
</script>
