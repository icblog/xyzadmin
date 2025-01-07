<template>
  <Layout pageTitle="view-temp-offsite" pageIntro="View temp offsite">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="7" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <section v-if="view_temp_offsite_data.custom_err != ''">
              <div class="row">
                <div class="col-md-12">
                  <HandleMsg
                    infotype="error"
                    customClass="no-border text-center"
                    :msg="view_temp_offsite_data.custom_err"
                  />
                </div>
              </div>
            </section>
            <section v-else>
              <div class="row">
                <div class="col-md-6 mobile-margin-bottom ml-0">
                  <div class="btn-group">
                    <AppButton
                      btnType="button"
                      customClass="primary-btn"
                      :btnFunc="toggleSearchWrapperDiv"
                    >
                      <span v-if="view_temp_offsite_data.show_search_wrapper">
                        <i class="fas fa-times"></i
                      ></span>
                      <span v-else><i class="fas fa-search"></i></span>
                    </AppButton>
                    <span
                      v-show="
                        !view_temp_offsite_data.is_searching &&
                        view_temp_offsite_data.data_len > 0
                      "
                    >
                      <AppButton
                        btnType="button"
                        customClass="primary-btn ml-3"
                        :btnFunc="() => printAllOrConvertToPdf('pdf')"
                      >
                        Convert to PDF
                      </AppButton>

                      <AppButton
                        btnType="button"
                        customClass="primary-btn ml-3"
                        :btnFunc="() => printAllOrConvertToPdf('print')"
                      >
                        Print all
                      </AppButton>
                    </span>
                    <!-- end div button-group -->
                  </div>

                  <!-- end div col-6 -->
                </div>

                <div class="col-md-6 mobile-margin-bottom ml-0">
                  <div
                    v-show="
                      !view_temp_offsite_data.is_searching &&
                      view_temp_offsite_data.data_len > 0
                    "
                  >
                    <OptionElementInput
                      :defaultOptionSelected="view_temp_offsite_data.selected_sort_option"
                      labelName="Sort:"
                      :allowSearch="false"
                      :labelPrepend="true"
                      :disabledInput="true"
                      :resultObj="option_select_arr"
                      @updateSelectedOptionInput="updateSelectedOptionInput"
                    />
                  </div>
                  <!-- end div col-6 -->
                </div>

                <!-- end div row -->
              </div>
              <div
                class="row viewallvisitors-search-wrapper"
                v-show="view_temp_offsite_data.show_search_wrapper"
              >
                <div
                  v-show="view_temp_offsite_data.search_form_err"
                  class="col-md-12 text-center"
                >
                  <p class="text-danger small">
                    Please select date range or enter co-worker/visitor first name.
                  </p>
                  <!-- end div col-12 -->
                </div>
                <div class="col-md-6 mb-3">
                  <span class="small bolded pr-2">Start date:</span>
                  <span @click="removeErrorOnSearchForm">
                    <Datepicker
                      v-model="start_date"
                      format="dd/MM/yyyy"
                      placeholder="Pick a date"
                      :disabled-dates="{
                        to: lower_limit,
                        from: upper_limit,
                      }"
                      :prevent-disable-date-selection="true"
                    >
                    </Datepicker>
                  </span>
                  <!-- end div col-6 -->
                </div>
                <div class="col-md-6 mb-3">
                  <span class="small bolded pr-2">End date:</span>
                  <span @click="removeErrorOnSearchForm">
                    <Datepicker
                      v-model="end_date"
                      format="dd/MM/yyyy"
                      placeholder="Pick a date"
                      :disabled-dates="{
                        to: lower_limit,
                        from: upper_limit,
                      }"
                      :prevent-disable-date-selection="true"
                    >
                    </Datepicker>
                  </span>
                  <!-- end div col-6 -->
                </div>
                <div class="col-md-12">
                  <span class="small bolded">First or last name: </span>
                  <span class="small">(optional)</span>
                  <div class="input-group">
                    <input
                      v-model="view_temp_offsite_data.co_worker_visitor_fname"
                      type="text"
                      class="form-control"
                      placeholder="First or last name of co-worker or visitor...."
                      @focus="removeErrorOnSearchForm"
                    />
                  </div>
                  <!-- end div col-12 -->
                </div>

                <div class="col-md-6 mx-auto">
                  <AppButton
                    btnType="button"
                    :fullBtn="true"
                    customClass="primary-btn mt-3"
                    :btnFunc="handleSearchBtn"
                  >
                    Search
                  </AppButton>
                  <!-- end div col-6 mx-auto-->
                </div>

                <!-- end row -->
              </div>
              <div class="view-alltempoffsite-result-wrapper">
                <div class="row">
                  <div class="col-md-12" v-show="view_temp_offsite_data.is_searching">
                    <LoadingIndicator />
                    <!-- end co-md-12 -->
                  </div>
                  <div
                    class="col-md-12"
                    v-show="
                      !view_temp_offsite_data.is_searching &&
                      view_temp_offsite_data.data_len > 0
                    "
                  >
                    <div class="mt-5 pt-5" v-show="view_temp_offsite_data.is_sorting">
                      <LoadingIndicator />
                      <!-- end div -->
                    </div>

                    <div v-show="!view_temp_offsite_data.is_sorting">
                      <hr class="mb-0" />
                      <span class="small">{{
                        view_temp_offsite_data.current_records_on_page +
                        " of " +
                        view_temp_offsite_data.total_records +
                        " total"
                      }}</span>
                      <!-- end div -->
                      <hr class="mt-0" />
                    </div>
                    <!-- end co-md-12 -->
                  </div>
                  <!-- end row -->
                </div>

                <TempOffSiteDetailsCard
                  v-show="
                    !view_temp_offsite_data.is_sorting &&
                    !view_temp_offsite_data.is_searching
                  "
                  :temp_offsite_result="view_temp_offsite_data.temp_offsite_res"
                  :show_sign_in="true"
                  :show_btn="false"
                />

                <div class="row pt-4">
                  <div
                    v-show="
                      temp_offsite_res_data.next_page_url != null &&
                      !view_temp_offsite_data.is_sorting &&
                      !view_temp_offsite_data.is_searching
                    "
                    class="col-md-6 mx-auto"
                  >
                    <AppButton
                      btnType="button"
                      :fullBtn="true"
                      customClass="primary-btn"
                      :btnFunc="handleLoadMoreTempOffsiteResult"
                    >
                      <span v-if="view_temp_offsite_data.is_paginating">
                        <LoadingIndicator loaderSize="small" :showBelowText="false" />
                      </span>
                      <span v-else> Load more </span>
                    </AppButton>
                    <!-- div col-6  -->
                  </div>
                  <div
                    v-show="
                      view_temp_offsite_data.data_len <= 0 &&
                      view_temp_offsite_data.is_fetching_data_complete
                    "
                    class="col-md-12 pt-3 text-center"
                  >
                    <HandleMsg
                      infotype="info"
                      msg="Sorry no records found"
                      customClass="no-border"
                    />
                    <!-- div col-12  -->
                  </div>
                  <!-- end row -->
                </div>

                <!-- end view-alltempoffsite-result-wrapper -->
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";
import Datepicker from "vuejs3-datepicker";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import OptionElementInput from "../../shared/OptionElementInput";
import LoadingIndicator from "../../shared/LoadingIndicator";
import TempOffSiteDetailsCard from "../../shared/TempOffSiteDetailsCard";
import {
  returnCurrentDate,
  toSqlDatetime,
  generatePdf,
  returnSortOptionArray,
  scrollToTopOrBottomOfPage,
} from "../../helper/util";

const current_date = returnCurrentDate(false);
const upper_limit = ref(current_date);
const lower_limit = ref(new Date(current_date.getFullYear() + "-" + 1 + "-" + 1));
const start_date = ref(current_date);
const end_date = ref(current_date);
const option_select_arr = returnSortOptionArray();

const props = defineProps({
  errors: Object,
  temp_offsite_res_data: {},
});
const view_temp_offsite_data = reactive({
  custom_err: props.errors?.fail == undefined ? "" : props.errors?.fail,
  is_sorting: false,
  selected_sort_option: option_select_arr[0].name,
  is_fetching_data_complete: false,
  co_worker_visitor_fname: "",
  search_form_err: false,
  is_paginating: false,
  is_searching: false,
  show_search_wrapper: false,
  temp_offsite_res: props.temp_offsite_res_data?.data,
  data_len: props.temp_offsite_res_data?.data.length,
  total_records: props.temp_offsite_res_data?.total,
  current_records_on_page: props.temp_offsite_res_data?.data.length,
});

const removeErrorOnSearchForm = () => {
  view_temp_offsite_data.search_form_err = false;
};
const toggleSearchWrapperDiv = () => {
  view_temp_offsite_data.show_search_wrapper = !view_temp_offsite_data.show_search_wrapper;
};

const assignDataFromAxiosCall = (isPagnateResult) => {
  view_temp_offsite_data.data_len = props.temp_offsite_res_data?.data.length;
  view_temp_offsite_data.total_records = props.temp_offsite_res_data?.total;

  //if paginate result, add else replace.
  if (isPagnateResult) {
    view_temp_offsite_data.temp_offsite_res = [
      ...view_temp_offsite_data.temp_offsite_res,
      ...props.temp_offsite_res_data?.data,
    ];
    view_temp_offsite_data.current_records_on_page =
      view_temp_offsite_data.current_records_on_page +
      props.temp_offsite_res_data?.data.length;
  } else {
    view_temp_offsite_data.temp_offsite_res = props.temp_offsite_res_data?.data;
    view_temp_offsite_data.current_records_on_page =
      props.temp_offsite_res_data?.data.length;
  }
};

const returnDataToBePost = () => {
  let has_date_changed = false;
  if (start_date.value != current_date || end_date.value != current_date) {
    has_date_changed = true;
  }
  return {
    selected_sort_option: view_temp_offsite_data.selected_sort_option,
    co_worker_visitor_fname: view_temp_offsite_data.co_worker_visitor_fname,
    start_date: toSqlDatetime(start_date.value),
    end_date: toSqlDatetime(end_date.value),
    has_date_changed: has_date_changed,
  };
};

const handleLoadMoreTempOffsiteResult = async () => {
  if (!view_temp_offsite_data.is_searching) {
    if (props.temp_offsite_res_data?.next_page_url === null) {
      return;
    }

    router.post(props.temp_offsite_res_data?.next_page_url, returnDataToBePost(), {
      preserveState: true,
      preserveScroll: true,
      only: ["temp_offsite_res_data"],
      onStart: () => {
        view_temp_offsite_data.is_paginating = true;
      },
      onFinish: () => {
        view_temp_offsite_data.is_paginating = false;
      },
      onSuccess: () => {
        window.history.replaceState({}, "", props.temp_offsite_res_data?.path);
        scrollToTopOrBottomOfPage("bottom");
        assignDataFromAxiosCall(true);
      },
    });
  } // end if !view_temp_offsite_data.is_searching
};

const viewAllTempOffsite = async () => {
  if (view_temp_offsite_data.show_search_wrapper) {
    view_temp_offsite_data.show_search_wrapper = false;
  }

  router.post("/tempoffsite/view", returnDataToBePost(), {
    onStart: () => {
      view_temp_offsite_data.is_fetching_data_complete = false;
    },
    onFinish: () => {
      view_temp_offsite_data.is_fetching_data_complete = true;
      if (view_temp_offsite_data.is_searching) {
        view_temp_offsite_data.is_searching = false;
      }
      if (view_temp_offsite_data.is_sorting) {
        view_temp_offsite_data.is_sorting = false;
      }
    },
    onSuccess: () => {
      assignDataFromAxiosCall(false);
    },
  });
};
const updateSelectedOptionInput = async (selected_sort_option) => {
  view_temp_offsite_data.is_sorting = true;
  view_temp_offsite_data.selected_sort_option = selected_sort_option;
  view_temp_offsite_data.current_records_on_page = 0;
  viewAllTempOffsite();
};
const printAllOrConvertToPdf = (action) => {
  // Create or print a new PDF document
  let column_arr = ["First name", "Last name", "Out at", "In at", "Department/Company"],
    attr_arr = ["fname", "lname", "time_out", "time_in", "depart_comp"],
    print_or_convert = false,
    record_text = "Record";
  if (action == "print") {
    print_or_convert = true;
  }

  if (view_temp_offsite_data.data_len > 1) {
    record_text = "Records";
  }

  generatePdf(
    jsPDF,
    autoTable,
    column_arr,
    attr_arr,
    view_temp_offsite_data.temp_offsite_res,
    record_text,
    print_or_convert,
    ["time_out", "time_in"]
  );
};

const handleSearchBtn = () => {
  if (
    start_date.value != current_date ||
    end_date.value != current_date ||
    view_temp_offsite_data.co_worker_visitor_fname != ""
  ) {
    view_temp_offsite_data.is_searching = true;
    view_temp_offsite_data.current_records_on_page = 0;
    view_temp_offsite_data.selected_sort_option = "Latest";
    removeErrorOnSearchForm();
    viewAllTempOffsite();
  } else {
    view_temp_offsite_data.search_form_err = true;
  }
};
</script>
