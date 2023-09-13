<template>
  <section
    v-show="
      currentVisitorsData.customErr != '' &&
      currentVisitorsData.dataLength <= 0 &&
      currentVisitorsData.isFetchingDataComplete
    "
  >
    <HandleMsg
      infotype="error"
      customClass="no-border text-center"
      :msg="currentVisitorsData.customErr"
    />
  </section>

  <section
    v-show="currentVisitorsData.customErr == '' && currentVisitorsData.dataLength > 0"
  >
    <div class="row">
      <div class="col">
        <p class="pt-3">
          {{
            currentVisitorsData.dataLength > 0
              ? "(" + currentVisitorsData.dataLength + ") visitors or contractors on site"
              : "(" + currentVisitorsData.dataLength + ") visitor on or contractors site"
          }}
        </p>
      </div>

      <div class="col text-right">
        <AppButton
          :noBtnStyle="true"
          customClass="ml-2 primary-btn"
          :btnFunc="printAllVisitors"
        >
          Print all</AppButton
        >
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="input-group current-visitor-sort-option-wrapper">
          <div class="input-group-prepend">
            <label class="form-label" for="reason">Sort:</label>
          </div>
          <div class="current-visitor-sort-option-selected form-control">
            <div>
              {{ currentVisitorsData.optionSelected }}
            </div>
            <div v-show="currentVisitorsData.isSortOptionDivOpened">
              <OptionElement
                customWrapperClass="current-visitor-sort-option-select-wrapper"
                :resultObj="optionSelectArr"
                :allowSearch="false"
                :optionSelected="currentVisitorsData.optionSelected"
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
                  currentVisitorsData.isSortOptionDivOpened
                    ? 'fas fa-arrow-up'
                    : 'fas fa-arrow-down'
                "
              ></i>
            </AppButton>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="current-visitors-search-wrapper">
          <LocalSearch
            :oldResultObj="currentVisitorsData.oldVisitorsRes"
            whatToCheck="fname"
            inputPlaceHolderValue="Visitor first name...."
            @updateResultObj="updateLocalResultSet"
          />
        </div>
      </div>
    </div>
    <!-- <div class="row">
      <div class="col-md-12">
        <VisitorAttr :vistorsResultSetData="currentVisitorsData.currentVisitorsRes" />
      </div>
    </div> -->
    <div
      v-for="(visitor, index) in currentVisitorsData.currentVisitorsRes"
      class="row pt-3"
    >
      <div class="col-md-12">
        <VisitorsDetailsCard
          :visitor="visitor"
          :handleSignOutVisitor="handleSignOutVisitor"
        />
      </div>
    </div>
  </section>
  <section
    v-show="
      currentVisitorsData.customErr == '' &&
      currentVisitorsData.dataLength <= 0 &&
      currentVisitorsData.isFetchingDataComplete
    "
  >
    <div class="row">
      <div class="col-md-12 text-center">
        <section v-if="currentVisitorsData.isPageResting">
          <LoadingIndicator />
        </section>
        <section v-else>
          <HandleMsg infotype="info" msg="No visitors on site" customClass="no-border" />
          <AppButton btnType="button" customClass="primary-btn" :btnFunc="resetPageData">
            Reset Data
          </AppButton>
        </section>
      </div>
    </div>
    <!-- end row -->
  </section>
</template>

<script setup>
import { reactive, onMounted } from "vue";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import AppButton from "../shared/AppButton";
import LocalSearch from "../shared/LocalSearch";
import OptionElement from "../shared/OptionElement";
import HandleMsg from "../shared/HandleMsg";
import VisitorsDetailsCard from "../shared/VisitorsDetailsCard";
//import VisitorAttr from "../shared/VisitorAttr";
import LoadingIndicator from "../shared/LoadingIndicator";
import {
  returnSystemErrorMsg,
  removeItemFromArrOrObjByValue,
  toSqlDatetime,
  generatePdf,
  returnSortOptionArray,
} from "../helper/util";
import axios from "../api/axios";
const optionSelectArr = returnSortOptionArray();

const props = defineProps({
  menuItemClicked: {
    type: String,
    default: "",
  },
});

const currentVisitorsData = reactive({
  oldVisitorsRes: [],
  currentVisitorsRes: [],
  currentlyActiveIndex: null,
  dataLength: 0,
  customErr: "",
  isSortOptionDivOpened: false,
  optionSelected: "Latest",
  isFetchingDataComplete: false,
  //remove isPageResting at later date
  isPageResting: false,
});

const toggleSortOptionDiv = () => {
  currentVisitorsData.isSortOptionDivOpened = !currentVisitorsData.isSortOptionDivOpened;
};

const sortCurrentVisitor = async (selectedSortOption) => {
  currentVisitorsData.isFetchingDataComplete = false;
  try {
    const res = await axios.post("/sort-current-visitor", {
      selectedSortOption: selectedSortOption,
    });

    if (res?.data?.error != "") {
      currentVisitorsData.customErr = res.data.error;
    } else {
      currentVisitorsData.optionSelected = selectedSortOption;
      currentVisitorsData.currentVisitorsRes = res?.data?.currentVisitorsResult;
      currentVisitorsData.oldVisitorsRes = res?.data?.currentVisitorsResult;
      currentVisitorsData.dataLength = res?.data?.currentVisitorsResult.length;
    }
  } catch (err) {
    currentVisitorsData.customErr = returnSystemErrorMsg();
  } finally {
    currentVisitorsData.isFetchingDataComplete = true;
  }
};

const updateSelectedOptionInput = async (selectedSortOption) => {
  currentVisitorsData.isSortOptionDivOpened = false;
  sortCurrentVisitor(selectedSortOption);
};
const updateLocalResultSet = (filteredResult) => {
  currentVisitorsData.currentVisitorsRes = filteredResult.arrObj;
};

const handleSignOutVisitor = async (signedInId) => {
  try {
    const res = await axios.post("/signout-visitor", {
      signedInId: signedInId,
      currentDataTime: toSqlDatetime(new Date()),
    });

    if (res?.data?.error != "") {
      currentVisitorsData.customErr = res.data.error;
    } else {
      //Remove the deleted records from the page
      currentVisitorsData.currentVisitorsRes = removeItemFromArrOrObjByValue(
        signedInId,
        currentVisitorsData.currentVisitorsRes,
        "id"
      );
      currentVisitorsData.dataLength = currentVisitorsData.dataLength - 1;
    }
  } catch (err) {
    currentVisitorsData.customErr = returnSystemErrorMsg();
  }
};

const printAllVisitors = () => {
  //Make sure data is updated before printing
  sortCurrentVisitor("Date descending");

  setTimeout(() => {
    // Create a new PDF document
    let columnsArr = [
        "First name",
        "Last name",
        "Signed in",
        "Badge",
        "Company",
        "Phone",
        "Reason",
      ],
      attrArr = ["fname", "lname", "sign_in", "badge", "company", "phone", "reason"];

    generatePdf(
      jsPDF,
      autoTable,
      columnsArr,
      attrArr,
      currentVisitorsData.oldVisitorsRes,
      "Current visitors or contractors on site",
      true
    );
  }, 1000);
};

const refreshResult = () => {
  let time,
    events = ["click", "mousedown", "mousemove", "keypress", "scroll", "touchstart"];
  function doPageUpdate() {
    sortCurrentVisitor(currentVisitorsData.optionSelected);
  }

  function resetTimer() {
    clearInterval(time);

    time = setInterval(doPageUpdate, 60000);
    // 60000 milliseconds = 1 minute
  }

  events.forEach(function (name) {
    document.addEventListener(name, resetTimer, true);
  });
};

//FOR TESTING TO BE REMOVE AT A LATER DATE
const resetPageData = async () => {
  currentVisitorsData.isPageResting = true;
  try {
    const res = await axios.post("/reset-current-visitor");

    if (res?.data?.error != "") {
      currentVisitorsData.customErr = res.data.error;
    } else {
      currentVisitorsData.currentVisitorsRes = res?.data?.currentVisitorsResult;
      currentVisitorsData.oldVisitorsRes = res?.data?.currentVisitorsResult;
      currentVisitorsData.dataLength = res?.data?.currentVisitorsResult.length;
    }
  } catch (err) {
    currentVisitorsData.customErr = returnSystemErrorMsg();
  } finally {
    currentVisitorsData.isPageResting = false;
  }
};

onMounted(() => {
  if (props.menuItemClicked == "current visitors") {
    sortCurrentVisitor(currentVisitorsData.optionSelected);
    refreshResult();
  } //End props props.menuItemClicked = 'current visitors';
});
</script>
