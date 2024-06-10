<template>
  <Layout pageTitle="view-all-visitors" pageIntro="View visitors">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="1" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <section v-if="viewAllVisitorsData.customErr != ''">
              <div class="row">
                <div class="col-md-12">
                  <HandleMsg
                    infotype="error"
                    customClass="no-border text-center"
                    :msg="viewAllVisitorsData.customErr"
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
                      <span v-if="viewAllVisitorsData.showSearchWrapperDiv">
                        <i class="fas fa-times"></i
                      ></span>
                      <span v-else><i class="fas fa-search"></i></span>
                    </AppButton>
                    <span
                      v-show="
                        !viewAllVisitorsData.isSearching &&
                        viewAllVisitorsData.dataLength > 0
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
                  </div>
                </div>

                <div class="col-md-6">
                  <div
                    v-show="
                      !viewAllVisitorsData.isSearching &&
                      viewAllVisitorsData.dataLength > 0
                    "
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
                v-show="viewAllVisitorsData.showSearchWrapperDiv"
              >
                <div
                  v-show="viewAllVisitorsData.searchFormError"
                  class="col-md-12 text-center"
                >
                  <p class="text-danger small">
                    Please select date range or enter co-worker/visitor first name.
                  </p>
                </div>
                <div class="col-md-6 mb-3">
                  <span class="small bolded pr-2">Start date:</span>
                  <span @click="removeErrorOnSearchForm">
                    <Datepicker
                      v-model="startDate"
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
                      v-model="endDate"
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
                  <span class="small bolded">First name: </span>
                  <span class="small">(optional)</span>
                  <div class="input-group">
                    <input
                      v-model="viewAllVisitorsData.coworkerOrVisitorFname"
                      type="text"
                      class="form-control"
                      placeholder="First name of co-worker or visitor ...."
                      @focus="removeErrorOnSearchForm"
                    />
                  </div>
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
                </div>

                <!-- end row -->
              </div>

              <div class="viewallvistors-result-wrapper">
                <div v-show="viewAllVisitorsData.isSearching" class="row">
                  <div class="col-md-12">
                    <LoadingIndicator />
                  </div>
                </div>

                <div
                  v-show="
                    !viewAllVisitorsData.isSearching && viewAllVisitorsData.dataLength > 0
                  "
                >
                  <div class="mt-5 pt-5" v-show="viewAllVisitorsData.isSorting">
                    <LoadingIndicator />
                  </div>
                  <div v-show="!viewAllVisitorsData.isSorting" class="pt-1">
                    <div class="row">
                      <div class="col-md-12 pt-0 pb-0">
                        <span class="small">{{
                          viewAllVisitorsData.currentRecordsOnPage +
                          " of " +
                          viewAllVisitorsData.totalRecords +
                          " total"
                        }}</span>
                      </div>
                    </div>
                    <VisitorsDetailsCard
                      :showBtn="false"
                      :visitorResult="viewAllVisitorsData.viewVisitorsRes"
                    />
                    <div v-show="viewAllVisitorsData.dataLength > 8" class="row">
                      <div class="col-md-12 pt-0 pb-0">
                        <span class="small">{{
                          viewAllVisitorsData.currentRecordsOnPage +
                          " of " +
                          viewAllVisitorsData.totalRecords +
                          " total"
                        }}</span>
                      </div>
                    </div>
                    <div
                      v-show="viewAllVisitorsRes.next_page_url != null"
                      class="row pt-4"
                    >
                      <div class="col-md-6 mx-auto">
                        <AppButton
                          btnType="button"
                          :fullBtn="true"
                          customClass="primary-btn"
                          :btnFunc="handleLoadMoreResult"
                        >
                          <span v-if="viewAllVisitorsData.isPaginating">
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
                    viewAllVisitorsData.dataLength <= 0 &&
                    viewAllVisitorsData.isFetchingDataComplete
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
  </Layout>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import Datepicker from "vuejs3-datepicker";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import AppButton from "../../shared/AppButton";
import OptionElementInput from "../../shared/OptionElementInput";
import HandleMsg from "../../shared/HandleMsg";
import VisitorsDetailsCard from "../../shared/VisitorsDetailsCard";
import LoadingIndicator from "../../shared/LoadingIndicator";
import SideBar from "../../shared/SideBar";
import Layout from "../../shared/Layout";
import {
  returnCurrentDate,
  toSqlDatetime,
  generatePdf,
  returnSortOptionArray,
  scrollToTopOrBottomOfPage,
} from "../../helper/util";

const currentDate = returnCurrentDate(false);
const upperLimit = ref(currentDate);
const lowerLimit = ref(new Date(currentDate.getFullYear() + "-" + 1 + "-" + 1));
const startDate = ref(currentDate);
const endDate = ref(currentDate);
const optionSelectArr = returnSortOptionArray();

const props = defineProps({
  errors: Object,
  viewAllVisitorsRes: {},
});

const viewAllVisitorsData = reactive({
  viewVisitorsRes: props.viewAllVisitorsRes?.data,
  dataLength: props.viewAllVisitorsRes?.data.length,
  customErr: props.errors?.fail == undefined ? "" : props.errors?.fail,
  isSorting: false,
  optionSelected: "Latest",
  isFetchingDataComplete: false,
  showSearchWrapperDiv: false,
  coworkerOrVisitorFname: "",
  searchFormError: false,
  isSearching: false,
  isPaginating: false,
  totalRecords: props.viewAllVisitorsRes?.total,
  currentRecordsOnPage: props.viewAllVisitorsRes?.data.length,
});

const toggleSearchWrapperDiv = () => {
  viewAllVisitorsData.showSearchWrapperDiv = !viewAllVisitorsData.showSearchWrapperDiv;
};

const returnDataToBePost = () => {
  let isDateChanged = false;
  if (startDate.value != currentDate || endDate.value != currentDate) {
    isDateChanged = true;
  }
  return {
    selectedSortOption: viewAllVisitorsData.optionSelected,
    coworkerOrVisitorFname: viewAllVisitorsData.coworkerOrVisitorFname,
    startDate: toSqlDatetime(startDate.value),
    endDate: toSqlDatetime(endDate.value),
    isDateChanged: isDateChanged,
  };
};

const assignDataFromAxiosCall = (isPagnateResult) => {
  viewAllVisitorsData.dataLength = props.viewAllVisitorsRes?.data.length;
  viewAllVisitorsData.totalRecords = props.viewAllVisitorsRes?.total;
  //if paginate result, add else replace.
  if (isPagnateResult) {
    viewAllVisitorsData.viewVisitorsRes = [
      ...viewAllVisitorsData.viewVisitorsRes,
      ...props.viewAllVisitorsRes?.data,
    ];
    viewAllVisitorsData.currentRecordsOnPage =
      viewAllVisitorsData.currentRecordsOnPage + props.viewAllVisitorsRes?.data.length;
  } else {
    viewAllVisitorsData.viewVisitorsRes = props.viewAllVisitorsRes?.data;
    viewAllVisitorsData.currentRecordsOnPage = props.viewAllVisitorsRes?.data.length;
  }
};

const viewAllVisitor = async () => {
  viewAllVisitorsData.isFetchingDataComplete = false;

  if (viewAllVisitorsData.showSearchWrapperDiv) {
    viewAllVisitorsData.showSearchWrapperDiv = false;
  }

  router.post("/view-all-visitor", returnDataToBePost(), {
    onStart: () => {
      viewAllVisitorsData.isFetchingDataComplete = false;
    },
    onFinish: () => {
      viewAllVisitorsData.isFetchingDataComplete = true;
      if (viewAllVisitorsData.isSearching) {
        viewAllVisitorsData.isSearching = false;
      }
      if (viewAllVisitorsData.isSorting) {
        viewAllVisitorsData.isSorting = false;
      }
    },
    onSuccess: () => {
      assignDataFromAxiosCall(false);
    },
  });
};
const removeErrorOnSearchForm = () => {
  if (viewAllVisitorsData.searchFormError) {
    viewAllVisitorsData.searchFormError = false;
  }
};

const handleSearchBtn = () => {
  if (
    startDate.value != currentDate ||
    endDate.value != currentDate ||
    viewAllVisitorsData.coworkerOrVisitorFname != ""
  ) {
    viewAllVisitorsData.isSearching = true;
    viewAllVisitorsData.currentRecordsOnPage = 0;
    viewAllVisitorsData.optionSelected = "Latest";
    removeErrorOnSearchForm();
    viewAllVisitor();
  } else {
    viewAllVisitorsData.searchFormError = true;
  }
};

const updateSelectedOptionInput = async (selectedSortOption) => {
  viewAllVisitorsData.isSorting = true;
  viewAllVisitorsData.optionSelected = selectedSortOption;
  viewAllVisitorsData.currentRecordsOnPage = 0;
  viewAllVisitor();
};

const printAllOrConvertToPdf = (printAllOrConvertToPdfBtn) => {
  // Create a new PDF document
  let printRecords = false,
    columnsArr = [
      "First name",
      "Last name",
      "Signed in",
      "Signed out",
      "Badge",
      "Company",
      "Phone",
      "Reason",
    ],
    attrArr = [
      "fname",
      "lname",
      "sign_in",
      "sign_out",
      "badge",
      "company",
      "phone",
      "reason",
    ];

  //Check if printAll Or ConvertToPdf Btn that was cliked
  if (printAllOrConvertToPdfBtn == "print") {
    printRecords = true;
  }
  generatePdf(
    jsPDF,
    autoTable,
    columnsArr,
    attrArr,
    viewAllVisitorsData.viewVisitorsRes,
    "Records",
    printRecords
  );
};

const handleLoadMoreResult = async () => {
  if (!viewAllVisitorsData.isSearching) {
    if (props.viewAllVisitorsRes?.next_page_url === null) {
      return;
    }

    router.post(props.viewAllVisitorsRes?.next_page_url, returnDataToBePost(), {
      preserveState: true,
      preserveScroll: true,
      only: ["viewAllVisitorsRes"],
      onStart: () => {
        viewAllVisitorsData.isPaginating = true;
      },
      onFinish: () => {
        viewAllVisitorsData.isPaginating = false;
      },
      onSuccess: () => {
        window.history.replaceState({}, "", props.viewAllVisitorsRes?.path);
        scrollToTopOrBottomOfPage("bottom");
        assignDataFromAxiosCall(true);
      },
    });
  } // end if !viewAllVisitorsData.isSearching
};
</script>
