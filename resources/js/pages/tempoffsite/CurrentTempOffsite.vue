<template>
  <Layout pageTitle="current-temp-offsite" pageIntro="Current temp offsite">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="7" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <section
              v-show="
                current_temp_offsite_data.custom_err != '' &&
                current_temp_offsite_data.res_data_len <= 0 &&
                current_temp_offsite_data.is_fetching_data_complete
              "
            >
              <HandleMsg
                infotype="error"
                customClass="no-border text-center"
                :msg="current_temp_offsite_data.custom_err"
              />
            </section>
            <section
              v-show="
                current_temp_offsite_data.custom_err == '' &&
                current_temp_offsite_data.res_data_len > 0
              "
            >
              <div class="row">
                <div class="col">
                  <p class="pt-3">
                    {{
                      current_temp_offsite_data.res_data_len > 0
                        ? "(" +
                          current_temp_offsite_data.res_data_len +
                          ") people are temporary offsite"
                        : "(" +
                          current_temp_offsite_data.res_data_len +
                          ") people are temporary offsite"
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

              <div class="row mb-3">
                <div class="col-md-6">
                  <OptionElementInput
                    defaultOptionSelected="Latest"
                    labelName="Sort:"
                    :allowSearch="false"
                    :labelPrepend="true"
                    :disabledInput="true"
                    :resultObj="option_select_arr"
                    @updateSelectedOptionInput="updateSelectedOptionInput"
                  />
                </div>
                <div class="col-md-6">
                  <div class="current-visitors-search-wrapper">
                    <LocalSearch
                      :oldResultObj="
                        current_temp_offsite_data.old_current_temp_offsite_res
                      "
                      whatToCheck="fname"
                      inputPlaceHolderValue="Enter first name...."
                      @updateResultObj="updateLocalResultSet"
                    />
                  </div>
                </div>
              </div>
              <div class="mt-5 pt-5" v-if="current_temp_offsite_data.is_sorting">
                <LoadingIndicator />
              </div>
              <div v-else>
                <TempOffSiteDetailsCard
                  :temp_offsite_result="
                    current_temp_offsite_data.new_current_temp_offsite_res
                  "
                  :handleSignInVisitor="handleSignInVisitor"
                  :show_sign_in="false"
                />
              </div>
            </section>
            <section
              v-show="
                current_temp_offsite_data.custom_err == '' &&
                current_temp_offsite_data.res_data_len <= 0
              "
            >
              <HandleMsg
                infotype="info"
                customClass="no-border"
                msg="There are no one offsite at the moment."
              />
            </section>
            <!-- end div col 9 -->
          </div>
          <!-- end div row -->
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { reactive, onMounted } from "vue";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import LocalSearch from "../../shared/LocalSearch";
import OptionElementInput from "../../shared/OptionElementInput";
import LoadingIndicator from "../../shared/LoadingIndicator";
import TempOffSiteDetailsCard from "../../shared/TempOffSiteDetailsCard";
import {
  returnSystemErrorMsg,
  removeItemFromArrOrObjByValue,
  toSqlDatetime,
  generatePdf,
  returnSortOptionArray,
} from "../../helper/util";
import axios from "../../api/axios";
const option_select_arr = returnSortOptionArray();

const props = defineProps({
  errors: Object,
  current_temp_offsite_res: {},
});

const current_temp_offsite_data = reactive({
  old_current_temp_offsite_res: props.current_temp_offsite_res,
  new_current_temp_offsite_res: props.current_temp_offsite_res,
  res_data_len: props.current_temp_offsite_res.length,
  custom_err: props.errors?.fail == undefined ? "" : props.errors?.fail,
  optionSelected: "Latest",
  is_fetching_data_complete: false,
  is_sorting: false,
});
const handleSortCurrentTempOffSite = async (selected_sort_option) => {
  current_temp_offsite_data.is_fetching_data_complete = false;

  try {
    const res = await axios.post("/tempoffsite/sort", {
      selected_sort_option: selected_sort_option,
    });
    if (res.data?.error != "") {
      current_temp_offsite_data.custom_err = res.data?.error;
    } else {
      current_temp_offsite_data.old_current_temp_offsite_res =
        res.data?.current_temp_offsite_res;
      current_temp_offsite_data.new_current_temp_offsite_res =
        res.data?.current_temp_offsite_res;
      current_temp_offsite_data.res_data_len = res.data?.current_temp_offsite_res.length;
    }
  } catch (error) {
    current_temp_offsite_data.custom_err = returnSystemErrorMsg();
  } finally {
    current_temp_offsite_data.is_fetching_data_complete = true;
    if (current_temp_offsite_data.is_sorting) {
      current_temp_offsite_data.is_sorting = false;
    }
  }
};
const updateSelectedOptionInput = (selected_sort_option) => {
  current_temp_offsite_data.is_sorting = true;
  handleSortCurrentTempOffSite(selected_sort_option);
};
const updateLocalResultSet = (filtered_res) => {
  current_temp_offsite_data.new_current_temp_offsite_res = filtered_res.arrObj;
};

const handleSignInVisitor = async (signed_out_id) => {
  try {
    const res = await axios.post("/tempoffsite/sign-in", {
      signed_out_id: signed_out_id,
      current_date_time: toSqlDatetime(new Date()),
    });

    if (res?.data?.error != "") {
      current_temp_offsite_data.custom_err = res.data.error;
    } else {
      //Remove the deleted records from the page
      current_temp_offsite_data.new_current_temp_offsite_res = removeItemFromArrOrObjByValue(
        signed_out_id,
        current_temp_offsite_data.new_current_temp_offsite_res,
        "id"
      );
      current_temp_offsite_data.old_current_temp_offsite_res =
        current_temp_offsite_data.new_current_temp_offsite_res;
      current_temp_offsite_data.res_data_len = current_temp_offsite_data.res_data_len - 1;
    }
  } catch (err) {
    current_temp_offsite_data.custom_err = returnSystemErrorMsg();
  }
};
const printAllVisitors = () => {
  //Make sure data is updated before printing
  handleSortCurrentTempOffSite("Date descending");

  setTimeout(() => {
    // Create a new PDF document
    let columnsArr = ["First name", "Last name", "Out at", "In at", "Department/Company"],
      attrArr = ["fname", "lname", "time_out", "time_in", "depart_comp"];

    generatePdf(
      jsPDF,
      autoTable,
      columnsArr,
      attrArr,
      current_temp_offsite_data.old_current_temp_offsite_res,
      "Current people offsite",
      true,
      ["time_out", "time_in"]
    );
  }, 1000);
};

const refreshResult = () => {
  let time,
    events = ["click", "mousedown", "mousemove", "keypress", "scroll", "touchstart"];
  function doPageUpdate() {
    //Only update the page if user is on it.
    if (window.location.href.includes("tempoffsite/current")) {
      handleSortCurrentTempOffSite("Date descending");
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

onMounted(() => {
  refreshResult();
});
</script>
