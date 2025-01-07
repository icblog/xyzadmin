<template>
  <Layout pageTitle="current-visitors" pageIntro="Current visitors">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="1" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
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
              v-show="
                currentVisitorsData.customErr == '' && currentVisitorsData.dataLength > 0
              "
            >
              <div class="row">
                <div class="col">
                  <p class="pt-3">
                    {{
                      currentVisitorsData.dataLength > 0
                        ? "(" +
                          currentVisitorsData.dataLength +
                          ") visitors or contractors on site"
                        : "(" +
                          currentVisitorsData.dataLength +
                          ") visitor on or contractors site"
                    }}
                  </p>
                </div>

                <div class="col text-right">
                  <AppButton
                    :noBtnStyle="true"
                    customClass="ml-2 primary-btn"
                    :btnFunc="printAllVisitors"
                  >
                    <i class="fas fa-print"></i
                  ></AppButton>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
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
              <div class="mt-5 pt-5" v-show="currentVisitorsData.isSorting">
                <LoadingIndicator />
              </div>
              <div v-show="!currentVisitorsData.isSorting">
                <VisitorsDetailsCard
                  :visitorResult="currentVisitorsData.currentVisitorsRes"
                  :handleSignOutVisitor="handleSignOutVisitor"
                  :showSignOut="false"
                />
              </div>
            </section>
            <section
              v-show="
                currentVisitorsData.customErr == '' && currentVisitorsData.dataLength <= 0
              "
            >
              <div class="row">
                <div class="col-md-12">
                  <HandleMsg
                    infotype="info"
                    msg="There are no visitors on site at the moment"
                    customClass="no-border"
                  />
                </div>

                <!-- <div class="col-md-12 text-center">
                  <div v-if="currentVisitorsData.isPageReseting">
                    <LoadingIndicator />
                  </div>
                  <div v-else>
                    <HandleMsg
                      infotype="info"
                      msg="There are no visitors on site at the moment"
                      customClass="no-border"
                    />
                    <AppButton
                      btnType="button"
                      customClass="primary-btn"
                      :btnFunc="resetPageData"
                    >
                      Reset Data
                    </AppButton>
                  </div>
                </div> -->
              </div>
              <!-- end row -->
            </section>

            <!-- end div col 9 -->
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { reactive, onMounted } from "vue";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import AppButton from "../../shared/AppButton";
import LocalSearch from "../../shared/LocalSearch";
import OptionElementInput from "../../shared/OptionElementInput";
import HandleMsg from "../../shared/HandleMsg";
import VisitorsDetailsCard from "../../shared/VisitorsDetailsCard";
import LoadingIndicator from "../../shared/LoadingIndicator";
import SideBar from "../../shared/SideBar";
import Layout from "../../shared/Layout";
import {
  returnSystemErrorMsg,
  removeItemFromArrOrObjByValue,
  toSqlDatetime,
  generatePdf,
  returnSortOptionArray,
} from "../../helper/util";
import axios from "../../api/axios";
const optionSelectArr = returnSortOptionArray();

const props = defineProps({
  errors: Object,

  currentVisitorsRes: {},
});

const currentVisitorsData = reactive({
  oldVisitorsRes: props.currentVisitorsRes,
  currentVisitorsRes: props.currentVisitorsRes,
  dataLength: props.currentVisitorsRes.length,
  customErr: props.errors?.fail == undefined ? "" : props.errors?.fail,
  optionSelected: "Latest",
  isFetchingDataComplete: false,
  //remove isPageReseting at later date
  //isPageReseting: false,
  isSorting: false,
});

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
    if (currentVisitorsData.isSorting) {
      currentVisitorsData.isSorting = false;
    }
  }
};

const updateSelectedOptionInput = (selectedSortOption) => {
  currentVisitorsData.isSorting = true;
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
      true,
      ["sign_in"]
    );
  }, 1000);
};

const refreshResult = () => {
  let time,
    events = ["click", "mousedown", "mousemove", "keypress", "scroll", "touchstart"];
  function doPageUpdate() {
    //Only update the page if user is on it.
    if (window.location.href.includes("/current-visitor")) {
      sortCurrentVisitor("Latest");
    } //end if window
  } // end do page update

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
// const resetPageData = async () => {
//   currentVisitorsData.isPageReseting = true;
//   try {
//     const res = await axios.post("/reset-current-visitor");

//     if (res?.data?.error != "") {
//       currentVisitorsData.customErr = res.data.error;
//     } else {
//       currentVisitorsData.currentVisitorsRes = res?.data?.currentVisitorsResult;
//       currentVisitorsData.oldVisitorsRes = res?.data?.currentVisitorsResult;
//       currentVisitorsData.dataLength = res?.data?.currentVisitorsResult.length;
//     }
//   } catch (err) {
//     currentVisitorsData.customErr = returnSystemErrorMsg();
//   } finally {
//     currentVisitorsData.isPageReseting = false;
//   }
// };

onMounted(() => {
  refreshResult();
});
</script>
