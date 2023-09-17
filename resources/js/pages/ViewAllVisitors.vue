<template>
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
              !viewAllVisitorsData.isSearching && viewAllVisitorsData.dataLength > 0
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
          v-show="!viewAllVisitorsData.isSearching && viewAllVisitorsData.dataLength > 0"
          class="input-group current-visitor-sort-option-wrapper"
        >
          <div class="input-group-prepend">
            <label class="form-label" for="reason">Sort:</label>
          </div>
          <div class="current-visitor-sort-option-selected form-control">
            <div>
              {{ viewAllVisitorsData.optionSelected }}
            </div>
            <div v-show="viewAllVisitorsData.isSortOptionDivOpened">
              <OptionElement
                customWrapperClass="current-visitor-sort-option-select-wrapper"
                :resultObj="optionSelectArr"
                :allowSearch="false"
                :optionSelected="viewAllVisitorsData.optionSelected"
                @updateSelectedOptionInput="updateSelectedOptionInput"
              />
            </div>
          </div>
          <div class="input-group-append">
            <AppButton
              btnType="button"
              customClass="option-toggle-btn"
              :btnFunc="toggleSortOptionDiv"
            >
              <i
                :class="
                  viewAllVisitorsData.isSortOptionDivOpened
                    ? 'fas fa-arrow-up'
                    : 'fas fa-arrow-down'
                "
              ></i>
            </AppButton>
          </div>
        </div>
      </div>
    </div>

    <!-- end row -->
    <div
      class="row viewallvisitors-search-wrapper"
      v-show="viewAllVisitorsData.showSearchWrapperDiv"
    >
      <div v-show="viewAllVisitorsData.searchFormError" class="col-md-12 text-center">
        <p class="text-danger small">
          Please select date range or enter co-worker/visitor first name.
        </p>
      </div>
      <div class="col-md-6 mb-3">
        <span class="small bolded">Start date:</span>
        <span class="form-control" @click="removeErrorOnSearchForm">
          <Datepicker
            v-model="startDate"
            :partial-range="false"
            :lower-limit="lowerLimit"
            :upper-limit="upperLimit"
            :weekStartsOn="0"
            inputFormat="yyyy-MM-dd"
          ></Datepicker>
        </span>
      </div>
      <div class="col-md-6 mb-3">
        <span class="small bolded">End date:</span>
        <span class="form-control" @click="removeErrorOnSearchForm">
          <Datepicker
            v-model="endDate"
            :partial-range="false"
            :lower-limit="lowerLimit"
            :upper-limit="upperLimit"
            :weekStartsOn="0"
            inputFormat="yyyy-MM-dd"
          ></Datepicker>
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
          :btnFunc="handleSearhBtn"
        >
          Search
        </AppButton>
      </div>

      <!-- end row -->
    </div>
    <!-- end viewallvisitors-search-wrapper -->

    <div class="viewallvistors-result-wrapper">
      <div v-show="viewAllVisitorsData.isSearching" class="row">
        <div class="col-md-12">
          <LoadingIndicator />
        </div>
      </div>

      <div
        v-show="!viewAllVisitorsData.isSearching && viewAllVisitorsData.dataLength > 0"
      >
        <div class="row">
          <div class="col-md-12 pt-0 pb-0">
            <span class="small"
              >Total records: {{ viewAllVisitorsData.totalRecords }}</span
            >
          </div>
        </div>
        <div class="pt-1">
          <VisitorsDetailsCard
            :showBtn="false"
            :visitorResult="viewAllVisitorsData.currentVisitorsRes"
          />
        </div>
      </div>
      <div
        v-show="
          viewAllVisitorsData.dataLength <= 0 &&
          viewAllVisitorsData.isFetchingDataComplete
        "
        class="pt-3 text-center"
      >
        <HandleMsg infotype="info" msg="Sorry no records found" customClass="no-border" />
      </div>
    </div>
    <!-- end viewallvistors-result-wrapper -->
    <span ref="loadMoreIntersect" />
    <div v-show="viewAllVisitorsData.isPaginating" class="text-center pt-4 pb-4">
      <LoadingIndicator />
    </div>
  </section>
</template>

<script setup>
import { reactive, onMounted, ref } from "vue";
import Datepicker from "vue3-datepicker";

import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import AppButton from "../shared/AppButton";
import OptionElement from "../shared/OptionElement";
import HandleMsg from "../shared/HandleMsg";
import VisitorsDetailsCard from "../shared/VisitorsDetailsCard";
import LoadingIndicator from "../shared/LoadingIndicator";
import {
  returnSystemErrorMsg,
  toSqlDatetime,
  generatePdf,
  returnSortOptionArray,
} from "../helper/util";
import axios from "../api/axios";

const currentDate = new Date();
const upperLimit = ref(currentDate);
const lowerLimit = ref(new Date(currentDate.getFullYear() + "-" + 1 + "-" + 1));
const startDate = ref(currentDate);
const endDate = ref(currentDate);
const loadMoreIntersect = ref(null);
const optionSelectArr = returnSortOptionArray();
const axiosUrl = "/view-all-visitor";
const props = defineProps({
  menuItemClicked: {
    type: String,
    default: "",
  },
});

const viewAllVisitorsData = reactive({
  currentVisitorsRes: [],
  currentlyActiveIndex: null,
  dataLength: 0,
  customErr: "",
  isSortOptionDivOpened: false,
  isSortOptionSeletd: false,
  optionSelected: "Latest",
  isFetchingDataComplete: false,
  showSearchWrapperDiv: false,
  coworkerOrVisitorFname: "",
  searchFormError: false,
  isSearching: false,
  isPaginating: false,
  initialPageLoad: "yes",
  totalRecords: 0,
  pageNumber: 1,
  lastPageNumber: 0,
});

const toggleSortOptionDiv = () => {
  viewAllVisitorsData.isSortOptionDivOpened = !viewAllVisitorsData.isSortOptionDivOpened;
};

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
    initialPageLoad: viewAllVisitorsData.initialPageLoad,
    totalRecords: viewAllVisitorsData.totalRecords,
    pageNumber: viewAllVisitorsData.pageNumber,
  };
};

const assignDataFromAxiosCall = (res, isPagnateResult = false) => {
  viewAllVisitorsData.dataLength = res?.data?.viewAllVisitorsResult.length;
  viewAllVisitorsData.initialPageLoad = res?.data?.initialPageLoad;
  viewAllVisitorsData.totalRecords = res?.data?.totalRecords;
  viewAllVisitorsData.pageNumber = res?.data?.pageNumber;
  viewAllVisitorsData.lastPageNumber = res?.data?.lastPageNumber;
  //if paginate result, add else replace.
  if (isPagnateResult) {
    viewAllVisitorsData.currentVisitorsRes = [
      ...viewAllVisitorsData.currentVisitorsRes,
      ...res?.data?.viewAllVisitorsResult,
    ];
  } else {
    viewAllVisitorsData.currentVisitorsRes = res?.data?.viewAllVisitorsResult;
  }
};

const viewAllVisitor = async () => {
  viewAllVisitorsData.isFetchingDataComplete = false;

  if (viewAllVisitorsData.showSearchWrapperDiv) {
    viewAllVisitorsData.showSearchWrapperDiv = false;
  }
  try {
    const res = await axios.post(axiosUrl, returnDataToBePost());

    if (res?.data?.error != "") {
      viewAllVisitorsData.customErr = res.data?.error;
    } else {
      assignDataFromAxiosCall(res);
    }
  } catch (err) {
    //console.log(err);
    viewAllVisitorsData.customErr = returnSystemErrorMsg();
  } finally {
    viewAllVisitorsData.isFetchingDataComplete = true;
    if (viewAllVisitorsData.isSearching) {
      viewAllVisitorsData.isSearching = false;
    }
  }
};
const removeErrorOnSearchForm = () => {
  if (viewAllVisitorsData.searchFormError) {
    viewAllVisitorsData.searchFormError = false;
  }
};

const handleSearhBtn = () => {
  if (
    startDate.value != currentDate ||
    endDate.value != currentDate ||
    viewAllVisitorsData.coworkerOrVisitorFname != ""
  ) {
    viewAllVisitorsData.isSearching = true;
    viewAllVisitorsData.pageNumber = 1;
    removeErrorOnSearchForm();
    viewAllVisitor();
  } else {
    viewAllVisitorsData.searchFormError = true;
  }
};

const updateSelectedOptionInput = async (selectedSortOption) => {
  viewAllVisitorsData.isSortOptionDivOpened = false;
  viewAllVisitorsData.isSortOptionSeletd = true;
  viewAllVisitorsData.optionSelected = selectedSortOption;
  viewAllVisitorsData.pageNumber = 1;
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
    viewAllVisitorsData.currentVisitorsRes,
    "Records",
    printRecords
  );
};

const loadMoreVisitors = async () => {
  if (viewAllVisitorsData.pageNumber > viewAllVisitorsData.lastPageNumber) {
    return;
  }
  if (!viewAllVisitorsData.isSearching) {
    viewAllVisitorsData.isPaginating = true;
    try {
      const res = await axios.post(axiosUrl, returnDataToBePost());

      if (res?.data?.error != "") {
        viewAllVisitorsData.customErr = res.data?.error;
      } else {
        assignDataFromAxiosCall(res, true);
      }
    } catch (err) {
      viewAllVisitorsData.customErr = returnSystemErrorMsg();
    } finally {
      viewAllVisitorsData.isPaginating = false;
    }
  } // end if !viewAllVisitorsData.isSearching
};

onMounted(() => {
  if (props.menuItemClicked == "view all visitors") {
    viewAllVisitor();

    const observer = new IntersectionObserver((entries) =>
      entries.forEach((entry) => entry.isIntersecting && loadMoreVisitors(), {
        rootMargin: "-150px 0px 0px 0px",
      })
    );

    observer.observe(loadMoreIntersect.value);
  } //End props props.menuItemClicked = 'view all visitors';
});
</script>
