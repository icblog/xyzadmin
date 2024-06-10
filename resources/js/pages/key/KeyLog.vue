<template>
  <Layout pageTitle="view-key-log" pageIntro="View key log">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="6" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <section v-if="key_log_data.custom_err != ''">
              <div class="row">
                <div class="col-md-12">
                  <HandleMsg
                    infotype="error"
                    customClass="no-border text-center"
                    :msg="key_log_data.custom_err"
                  />
                </div>
              </div>
            </section>
            <section v-else>
              <div class="row">
                <div class="col-md-7 mobile-margin-bottom ml-0">
                  <div class="btn-group">
                    <AppButton
                      btnStyle="primary2"
                      :btnFunc="() => openLogAkeyModal('keyout')"
                    >
                      Log a key out <i class="fas fa-arrow-up"></i>
                    </AppButton>
                    <AppButton
                      btnType="button"
                      customClass="primary-btn ml-3"
                      :btnFunc="getAllRecords"
                    >
                      All records
                    </AppButton>
                    <AppButton
                      customClass="primary-btn ml-3"
                      :btnFunc="toggleSearchWrapperDiv"
                    >
                      <span v-if="key_log_data.show_search_wrapper_div">
                        <i class="fas fa-times"></i
                      ></span>
                      <span v-else><i class="fas fa-search"></i></span>
                    </AppButton>
                  </div>
                </div>

                <div class="col-md-5">
                  <div
                    v-show="!key_log_data.is_searching && key_log_data.data_length > 0"
                  >
                    <OptionElementInput
                      defaultOptionSelected="Latest"
                      labelName="Sort:"
                      :allowSearch="false"
                      :labelPrepend="true"
                      :disabledInput="true"
                      :resultObj="optionSelectArr"
                      @updateSelectedOptionInput="updateSelectedOptionInput"
                    />
                  </div>
                </div>
              </div>

              <!-- end row -->
              <div
                class="row viewallvisitors-search-wrapper"
                v-show="key_log_data.show_search_wrapper_div"
              >
                <div
                  v-show="key_log_data.search_form_error != ''"
                  class="col-md-12 text-center"
                >
                  <p class="text-danger small">
                    {{ key_log_data.search_form_error }}
                  </p>
                </div>
                <div class="col-md-6 mb-3">
                  <span class="small bolded pr-2">Start date:</span>
                  <span @click="removeErrorOnSearchForm">
                    <Datepicker
                      v-model="start_date"
                      format="dd/MM/yyyy"
                      placeholder="Pick a date"
                      :disabled-dates="{
                        to: lowerLimit,
                        from: upperLimit,
                      }"
                      :prevent-disable-date-selection="true"
                    >
                    </Datepicker>
                  </span>
                </div>
                <div class="col-md-6 mb-3">
                  <span class="small bolded pr-2">End date:</span>
                  <span @click="removeErrorOnSearchForm">
                    <Datepicker
                      v-model="end_date"
                      format="dd/MM/yyyy"
                      placeholder="Pick a date"
                      :disabled-dates="{
                        to: lowerLimit,
                        from: upperLimit,
                      }"
                      :prevent-disable-date-selection="true"
                    >
                    </Datepicker>
                  </span>
                </div>
                <div class="col-md-12">
                  <span class="small bolded">Key name: </span>
                  <span class="small">(optional)</span>
                  <div class="input-group">
                    <input
                      v-model="key_log_data.key_name"
                      type="text"
                      class="form-control"
                      placeholder="key name ...."
                      @focus="removeErrorOnSearchForm"
                    />
                  </div>
                </div>

                <div class="col-md-6 mx-auto">
                  <AppButton
                    :fullBtn="true"
                    customClass="primary-btn mt-3"
                    :btnFunc="handleSearchBtn"
                  >
                    Search
                  </AppButton>
                </div>

                <!-- end row -->
              </div>

              <div class="viewallvistors-result-wrapper">
                <div v-show="key_log_data.is_searching" class="row">
                  <div class="col-md-12">
                    <LoadingIndicator />
                  </div>
                </div>

                <div v-show="!key_log_data.is_searching && key_log_data.data_length > 0">
                  <div class="mt-5 pt-5" v-show="key_log_data.is_sorting">
                    <LoadingIndicator />
                  </div>
                  <div v-show="!key_log_data.is_sorting" class="pt-1">
                    <div class="row">
                      <div class="col-md-12 pt-0 pb-0">
                        <span class="small">{{
                          key_log_data.current_record_on_page +
                          " of " +
                          key_log_data.total_records +
                          " total"
                        }}</span>
                      </div>
                    </div>
                    <KeyLogDetailsCard
                      :key_log_result_details="key_log_data.key_log_result"
                      @handleKeyInModal="handleKeyInBtnClick"
                    />
                    <div v-show="key_log_data.data_length > 8" class="row">
                      <div class="col-md-12 pt-0 pb-0">
                        <span class="small">{{
                          key_log_data.current_record_on_page +
                          " of " +
                          key_log_data.total_records +
                          " total"
                        }}</span>
                      </div>
                    </div>
                    <div v-show="view_key_log_res.next_page_url != null" class="row pt-4">
                      <div class="col-md-6 mx-auto">
                        <AppButton
                          btnType="button"
                          :fullBtn="true"
                          customClass="primary-btn"
                          :btnFunc="handleLoadMoreResult"
                        >
                          <span v-if="key_log_data.is_paginating">
                            <LoadingIndicator loaderSize="small" :showBelowText="false" />
                          </span>
                          <span v-else> Load more </span>
                        </AppButton>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  v-show="
                    key_log_data.data_length <= 0 &&
                    key_log_data.is_fetching_data_complete
                  "
                  class="pt-3 text-center"
                >
                  <HandleMsg
                    infotype="info"
                    msg="Sorry no records found"
                    customClass="no-border"
                  />
                </div>
              </div>
              <!-- end viewallvistors-result-wrapper -->
            </section>

            <!-- end div col 9 -->
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL GOES HERE -->
    <Modal :showModal="key_log_data.show_modal" :showCloseBtn="false">
      <template v-slot:c-modal-content>
        <section v-show="key_log_data.action == 'keyout'">
          <KeyLogOutForm @handleModalClose="closeLogAkeyModal" />
        </section>
        <section v-show="key_log_data.action == 'keyin'">
          <KeyLogInForm
            @handleModalClose="closeLogAkeyModal"
            :key_log_obj="key_log_data.key_log_obj"
          />
        </section>
      </template>
    </Modal>
  </Layout>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { reactive, ref, onMounted } from "vue";
import Datepicker from "vuejs3-datepicker";
import KeyLogOutForm from "./KeyLogOutForm";
import KeyLogInForm from "./KeyLogInForm";
import Modal from "../../shared/Modal";
import AppButton from "../../shared/AppButton";
import OptionElementInput from "../../shared/OptionElementInput";
import HandleMsg from "../../shared/HandleMsg";
import KeyLogDetailsCard from "./KeyLogDetailsCard";
import LoadingIndicator from "../../shared/LoadingIndicator";
import SideBar from "../../shared/SideBar";
import Layout from "../../shared/Layout";
import {
  returnCurrentDate,
  toSqlDatetime,
  returnSortOptionArray,
  scrollToTopOrBottomOfPage,
} from "../../helper/util";

const current_date = returnCurrentDate(false);
const upperLimit = ref(current_date);
const lowerLimit = ref(new Date(current_date.getFullYear() + "-" + 1 + "-" + 1));
const start_date = ref("");
const end_date = ref("");
const optionSelectArr = returnSortOptionArray().concat({ name: "Key out" });

const props = defineProps({
  errors: Object,
  view_key_log_res: {},
});

const key_log_data = reactive({
  key_log_result: props.view_key_log_res?.data,
  data_length: props.view_key_log_res?.data.length,
  custom_err: props.errors?.fail == undefined ? "" : props.errors?.fail,
  is_sorting: false,
  option_selected: "Latest",
  is_fetching_data_complete: false,
  show_search_wrapper_div: false,
  key_name: "",
  search_form_error: "",
  is_searching: false,
  is_paginating: false,
  total_records: props.view_key_log_res?.total,
  current_record_on_page: props.view_key_log_res?.data.length,
  show_modal: false,
  action: "",
  key_log_obj: {},
});

const getAllRecords = () => {
  router.visit("/keys/log", { method: "get" });
};

const openLogAkeyModal = (btn_action = "") => {
  // console.log(btn_action);
  // return;
  key_log_data.action = btn_action;
  key_log_data.show_modal = true;
};

const closeLogAkeyModal = () => {
  key_log_data.action = "";
  key_log_data.show_modal = false;
};

const handleKeyInBtnClick = (key_log_obj) => {
  key_log_data.key_log_obj = key_log_obj;
  openLogAkeyModal("keyin");
};

const toggleSearchWrapperDiv = () => {
  key_log_data.show_search_wrapper_div = !key_log_data.show_search_wrapper_div;
};

const returnDataToBePost = () => {
  let has_date_changed = false;
  if (start_date.value != "" && end_date.value != "") {
    has_date_changed = true;
  }
  return {
    selected_sort_option: key_log_data.option_selected,
    key_name: key_log_data.key_name,
    start_date: start_date.value == "" ? "" : toSqlDatetime(start_date.value),
    end_date: end_date.value == "" ? "" : toSqlDatetime(end_date.value),
    has_date_changed: has_date_changed,
  };
};

const assignDataFromAxiosCall = (is_paginate_result) => {
  key_log_data.data_length = props.view_key_log_res?.data.length;
  key_log_data.total_records = props.view_key_log_res?.total;
  //if paginate result, add else replace.
  if (is_paginate_result) {
    key_log_data.key_log_result = [
      ...key_log_data.key_log_result,
      ...props.view_key_log_res?.data,
    ];
    key_log_data.current_record_on_page =
      key_log_data.current_record_on_page + props.view_key_log_res?.data.length;
  } else {
    key_log_data.key_log_result = props.view_key_log_res?.data;
    key_log_data.current_record_on_page = props.view_key_log_res?.data.length;
  }
};

const viewLog = async () => {
  key_log_data.is_fetching_data_complete = false;

  if (key_log_data.show_search_wrapper_div) {
    key_log_data.show_search_wrapper_div = false;
  }

  router.post("/keys/log", returnDataToBePost(), {
    onStart: () => {
      key_log_data.is_fetching_data_complete = false;
    },
    onFinish: () => {
      key_log_data.is_fetching_data_complete = true;
      if (key_log_data.is_searching) {
        key_log_data.is_searching = false;
      }
      if (key_log_data.is_sorting) {
        key_log_data.is_sorting = false;
      }
    },
    onSuccess: () => {
      assignDataFromAxiosCall(false);
    },
  });
};
const removeErrorOnSearchForm = () => {
  if (key_log_data.search_form_error != "") {
    key_log_data.search_form_error = "";
  }
};

const handleSearchBtn = () => {
  let abort = false;

  if (start_date.value == "" && end_date.value == "" && key_log_data.key_name == "") {
    abort = true;
    key_log_data.search_form_error = " Please select date range or enter key name.";
  }

  if (start_date.value != "" && end_date.value == "") {
    abort = true;
    key_log_data.search_form_error = " Please select end date.";
  }

  if (start_date.value == "" && end_date.value != "") {
    abort = true;
    key_log_data.search_form_error = " Please select start date.";
  }

  if (!abort) {
    removeErrorOnSearchForm();
    viewLog();
  }
};

const updateSelectedOptionInput = async (selected_sort_option) => {
  key_log_data.is_sorting = true;
  key_log_data.option_selected = selected_sort_option;
  key_log_data.current_record_on_page = 0;
  viewLog();
};

const handleLoadMoreResult = async () => {
  if (!key_log_data.is_searching) {
    if (props.view_key_log_res?.next_page_url === null) {
      return;
    }

    router.post(props.view_key_log_res?.next_page_url, returnDataToBePost(), {
      preserveState: true,
      preserveScroll: true,
      only: ["view_key_log_res"],
      onStart: () => {
        key_log_data.is_paginating = true;
      },
      onFinish: () => {
        key_log_data.is_paginating = false;
      },
      onSuccess: () => {
        window.history.replaceState({}, "", props.view_key_log_res?.path);
        scrollToTopOrBottomOfPage("bottom");
        assignDataFromAxiosCall(true);
      },
    });
  } // end if !key_log_data.is_searching
};

onMounted(() => {
  if (key_log_data.data_length <= 0) {
    key_log_data.is_fetching_data_complete = true;
  }
});
</script>
