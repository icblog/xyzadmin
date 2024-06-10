<template>
  <Layout pageTitle="view-absence" pageIntro="View absence">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="2" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <section v-if="view_absence_data.custom_err != ''">
              <div class="row">
                <div class="col-md-12">
                  <HandleMsg
                    infotype="error"
                    customClass="form-responds-msg text-center"
                    :msg="view_absence_data.custom_err"
                  />
                </div>
              </div>
            </section>
            <section v-else>
              <div class="row">
                <div class="col-md-12">
                  <h6>Today total absence by departments</h6>

                  <div class="absence-total-department-wrapper">
                    <span
                      v-if="view_absence_data.data_length > 0"
                      v-for="(department_absence, depart_ab_index) in department_result"
                      :key="depart_ab_index"
                    >
                      <span v-show="department_absence.name != 'All department'">
                        <AppButton
                          btnType="button"
                          :customClass="
                            department_absence.department_absence_total > 0
                              ? 'mt-1 department-absence-total-morethan-zerobtn'
                              : 'mt-1'
                          "
                          :btnFunc="
                            () =>
                              handleTodayDepartmentBtn(
                                department_absence.id,
                                department_absence.department_absence_total
                              )
                          "
                        >
                          {{
                            department_absence.name +
                            " (" +
                            department_absence.department_absence_total +
                            ")"
                          }}
                        </AppButton>
                      </span>
                    </span>
                  </div>
                </div>
                <!-- end row -->
              </div>
              <hr v-show="view_absence_data.data_length > 0" />
              <div class="row">
                <div class="col-md-6 mobile-margin-bottom ml-0">
                  <div class="btn-group">
                    <AppButton
                      btnType="button"
                      customClass="primary-btn mr-3"
                      :btnFunc="getAllRecords"
                    >
                      All records
                    </AppButton>
                    <AppButton
                      btnType="button"
                      customClass="primary-btn"
                      :btnFunc="toggleSearchWrapperDiv"
                    >
                      <span v-if="view_absence_data.show_search_wrapperdiv">
                        <i class="fas fa-times"></i
                      ></span>
                      <span v-else><i class="fas fa-search"></i></span>
                    </AppButton>
                  </div>
                </div>
                <div class="col-md-6">
                  <div
                    v-show="
                      !view_absence_data.is_searching &&
                      !view_absence_data.show_search_wrapperdiv &&
                      view_absence_data.data_length > 0
                    "
                  >
                    <OptionElementInput
                      defaultOptionSelected="Latest"
                      labelName="Sort:"
                      :allowSearch="false"
                      :labelPrepend="true"
                      :disabledInput="true"
                      :resultObj="option_select_arr"
                      @updateSelectedOptionInput="handleSortSelectOption"
                    />
                  </div>
                </div>
                <!-- end row -->
              </div>
              <div
                class="row view-absence-search-wrapper"
                v-show="view_absence_data.show_search_wrapperdiv"
              >
                <div class="col-md-6 mb-3">
                  <p
                    v-show="view_absence_data.start_date_error"
                    class="text-danger small"
                  >
                    Start date is required.
                  </p>

                  <span class="small bolded pr-2">Start date:</span>
                  <span @click="() => removeErrorOnSearchForm('start_date')">
                    <Datepicker
                      v-model="start_date"
                      format="dd/MM/yyyy"
                      placeholder="Pick a date"
                      :disabled-dates="{
                        to: lower_limit,
                      }"
                      :prevent-disable-date-selection="true"
                    >
                    </Datepicker>
                  </span>
                </div>
                <div class="col-md-6 mb-3">
                  <p v-show="view_absence_data.end_date_error" class="text-danger small">
                    End date is required.
                  </p>
                  <span class="small bolded pr-2">End date:</span>
                  <span @click="() => removeErrorOnSearchForm('end_date')">
                    <Datepicker
                      v-model="end_date"
                      format="dd/MM/yyyy"
                      placeholder="Pick a date"
                      :disabled-dates="{
                        to: lower_limit,
                      }"
                      :prevent-disable-date-selection="true"
                    >
                    </Datepicker>
                  </span>
                </div>
                <div class="col-md-6">
                  <span class="small bolded">Co-worker first name: </span>
                  <span class="small">(optional)</span>
                  <div class="input-group">
                    <input
                      v-model="view_absence_data.co_worker_name"
                      type="text"
                      class="form-control"
                      placeholder="First name of co-worker or visitor ...."
                    />
                  </div>
                </div>

                <div class="col-md-6">
                  <div>
                    <span class="small bolded">Department: </span>
                    <span class="small">(optional)</span>
                  </div>
                  <OptionElementInput
                    v-if="department_result.length > 0"
                    whatToget="id"
                    :defaultOptionSelected="view_absence_data.selected_department_id"
                    :disabledInput="true"
                    :resultObj="department_result"
                    itemToHide="All department"
                    @updateSelectedOptionInput="handleSearchDepartmentSelectOption"
                  />
                </div>
                <div class="col-md-8 mx-auto text-center pt-3">
                  <div class="form-group">
                    <div>
                      <span class="small bolded">Work related: </span>
                      <span class="small">(optional)</span>
                    </div>
                    <div class="form-check-inline">
                      <span class="form-check-label">
                        <input
                          type="radio"
                          class="form-check-input"
                          value="No"
                          v-model="view_absence_data.work_related"
                        />No
                      </span>
                    </div>
                    <div class="form-check-inline">
                      <span class="form-check-label">
                        <input
                          type="radio"
                          class="form-check-input"
                          value="Yes"
                          v-model="view_absence_data.work_related"
                        />Yes
                      </span>
                      <span
                        v-show="view_absence_data.work_related != ''"
                        class="work-related-reset-btn"
                        @click="resetWorkRelated"
                        >Reset</span
                      >
                    </div>
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
              <hr v-show="view_absence_data.data_length > 0" />
            </section>
            <section>
              <div v-show="view_absence_data.is_searching" class="row">
                <div class="col-md-12">
                  <LoadingIndicator />
                </div>
                <!-- end row -->
              </div>

              <div
                v-show="
                  !view_absence_data.is_searching && view_absence_data.data_length > 0
                "
              >
                <div v-show="view_absence_data.is_sorting" class="row">
                  <div class="col-md-12">
                    <LoadingIndicator />
                  </div>
                  <!-- end row -->
                </div>
                <div v-show="!view_absence_data.is_sorting">
                  <div class="pb-1 pl-2">
                    <span v-show="!view_absence_data.is_sorting" class="small">{{
                      returnTotalRecordsMsg()
                    }}</span>
                  </div>
                  <div
                    v-for="(absence, absence_index) in view_absence_data.view_absence_res"
                    :key="absence_index"
                    class="row"
                  >
                    <div class="col-md-12 mb-3">
                      <Accordion
                        :key="absence_index"
                        :activeIndex="view_absence_data.current_active_accordion_index"
                        :itemIndex="absence_index"
                        :extraTriggerFunc="handleCancleAbsenceBeingEditedBtn"
                        @update:itemIndex="
                          view_absence_data.current_active_accordion_index = $event
                        "
                      >
                        <template v-slot:accordion-trigger>
                          <div class="accordion-trigger-wrapper">
                            <div>
                              <span>
                                {{ absence.co_worker_name }}
                              </span>
                            </div>
                            <div>
                              <span>
                                {{ returnFormattedDate(absence.date_for) }}
                              </span>
                            </div>
                            <div>
                              <span>
                                {{ absence.department_name }}
                              </span>
                            </div>
                            <div>
                              <span
                                v-show="absence.responsible_told == null"
                                class="responsible-told-badge"
                              >
                              </span>

                              <span
                                v-show="
                                  absence.work_related == 'Yes' &&
                                  !checkDateDiff(absence.date_for, 8)
                                "
                                class="work-related-badge"
                              >
                              </span>
                            </div>
                          </div>
                        </template>
                        <template v-slot:accordion-content>
                          <div class="absence-result-wrapper">
                            <div class="row">
                              <div class="col-md-6">
                                <ul class="result-detail-ul cf">
                                  <li>
                                    Reference: <span>{{ absence.ref_number }}</span>
                                  </li>
                                  <li>
                                    Called in on:
                                    <span>{{
                                      returnFormattedDate(absence.created_at, true)
                                    }}</span>
                                  </li>

                                  <li>
                                    Reason:
                                    <span>{{ absence.reason }}</span>
                                  </li>
                                  <li>
                                    Worked related:
                                    <span>{{ absence.work_related }}</span>
                                  </li>

                                  <li>
                                    Date of absent:
                                    <span>{{
                                      returnFormattedDate(absence.date_for)
                                    }}</span>
                                  </li>
                                </ul>
                              </div>
                              <div class="col-md-6">
                                <ul class="result-detail-ul cf">
                                  <li>
                                    Shift start:
                                    <span>{{ absence.shift_start_time }}</span>
                                  </li>
                                  <li>
                                    Shift end:
                                    <span>{{ absence.shift_end_time }}</span>
                                  </li>
                                  <li>
                                    Comment:
                                    <span>{{ absence.comment }}</span>
                                  </li>
                                  <li>
                                    Logged by:
                                    <span>{{ absence.logged_by }}</span>
                                  </li>

                                  <li>
                                    responsible told:
                                    <span>{{
                                      absence.responsible_told == null
                                        ? "---"
                                        : absence.responsible_told
                                    }}</span>
                                  </li>

                                  <li>
                                    responsible told by:
                                    <span>{{
                                      absence.responsible_told_by == null
                                        ? "---"
                                        : absence.responsible_told_by
                                    }}</span>
                                  </li>

                                  <span
                                    v-show="
                                      absence.responsible_told == null &&
                                      !view_absence_data.is_phones_div_opened
                                    "
                                  >
                                    <AppButton
                                      btnType="button"
                                      :fullBtn="false"
                                      customClass="primary-btn mt-2"
                                      :btnFunc="
                                        () =>
                                          handleTellResponsibleBtn(absence_index, absence)
                                      "
                                    >
                                      Tell responsible
                                    </AppButton>
                                  </span>
                                </ul>
                              </div>

                              <!-- end row -->
                            </div>
                            <section
                              v-show="
                                absence.responsible_told == null &&
                                view_absence_data.absence_being_edited_obj.id ==
                                  absence.id
                              "
                            >
                              <hr class="pt-0 pb-0 mr-4 ml-4" />
                              <div class="form-wrapper">
                                <section v-if="view_absence_data.is_editing_absence">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <LoadingIndicator loaderSize="med" />
                                    </div>
                                    <!-- end row -->
                                  </div>
                                </section>

                                <section v-else>
                                  <section
                                    v-if="
                                      view_absence_data.absence_updated_error != '' &&
                                      view_absence_data.absence_being_edited_obj.id ==
                                        absence.id
                                    "
                                  >
                                    <div class="row">
                                      <div class="col-md-12">
                                        <HandleMsg
                                          infotype="error"
                                          customClass="form-responds-msg text-center small"
                                          :msg="view_absence_data.absence_updated_error"
                                        />
                                      </div>
                                      <!-- end row -->
                                    </div>
                                  </section>

                                  <section
                                    v-else-if="
                                      view_absence_data.absence_updated_success != '' &&
                                      view_absence_data.absence_being_edited_obj.id ==
                                        absence.id
                                    "
                                  >
                                    <div class="row">
                                      <div class="col-md-12">
                                        <HandleMsg
                                          infotype="success"
                                          customClass="form-responds-msg text-center small"
                                          :msg="view_absence_data.absence_updated_success"
                                        />
                                      </div>
                                      <!-- end row -->
                                    </div>
                                  </section>
                                  <section v-else>
                                    <div class="row">
                                      <div class="col-md-12">
                                        <div class="text-right">
                                          <AppButton
                                            btnType="button"
                                            :fullBtn="false"
                                            customClass="backBtn"
                                            :btnFunc="handleCancleAbsenceBeingEditedBtn"
                                          >
                                            <span>
                                              <i class="fas fa-times"></i>
                                            </span>
                                          </AppButton>
                                        </div>
                                      </div>

                                      <!-- end row -->
                                    </div>
                                    <div class="row">
                                      <div
                                        v-show="
                                          view_absence_data.depart_phones.length > 0
                                        "
                                        class="col-md-6"
                                      >
                                        <AppButton
                                          :btnFunc="handleShowPhones"
                                          customClass="change-selected-btn"
                                        >
                                          Show phones
                                        </AppButton>
                                        <!-- end div col-md-6 -->
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <OptionElementInput
                                            v-if="view_absence_data.co_workers.length > 0"
                                            labelName="Co-workers/leaders
                                            "
                                            :defaultOptionSelected="
                                              view_absence_data.responsible_told
                                            "
                                            :disabledInput="true"
                                            :trimDetail="false"
                                            arrType="arr"
                                            :resultObj="view_absence_data.co_workers"
                                            @updateSelectedOptionInput="
                                              updateSelectedLeaderOrResponsible
                                            "
                                          />
                                        </div>
                                        <!-- end div col-md-6 -->
                                      </div>

                                      <!-- end row -->
                                    </div>
                                    <div class="row">
                                      <div
                                        v-show="
                                          view_absence_data.responsible_told !=
                                          select_placeholder
                                        "
                                        class="col-md-6 mx-auto pt-2"
                                      >
                                        <AppButton
                                          :btnFunc="handleUpdateAbsenceBtn"
                                          customClass="primary-btn"
                                        >
                                          Update
                                        </AppButton>
                                      </div>
                                      <!-- end row -->
                                    </div>
                                  </section>
                                </section>
                              </div>
                            </section>
                          </div>
                        </template>
                      </Accordion>
                    </div>
                  </div>
                </div>
              </div>
              <div v-show="view_absence_res.next_page_url != null" class="row pt-4">
                <div class="col-md-6 mx-auto">
                  <AppButton
                    btnType="button"
                    :fullBtn="true"
                    customClass="primary-btn"
                    :btnFunc="handleLoadMoreResult"
                  >
                    <span v-if="view_absence_data.is_paginating">
                      <LoadingIndicator loaderSize="small" :showBelowText="false" />
                    </span>
                    <span v-else> Load more </span>
                  </AppButton>
                </div>
              </div>
            </section>

            <section>
              <div v-show="view_absence_data.data_length <= 0" class="pt-3 text-center">
                <HandleMsg
                  infotype="info"
                  msg="Sorry no records found"
                  customClass="no-border"
                />
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL GOES HERE -->
    <Modal :showModal="view_absence_data.show_modal" :showCloseBtn="false">
      <template v-slot:c-modal-content>
        <AbsencePhoneDetails
          v-if="view_absence_data.depart_phone_cowokers_fetched"
          :view_phone_res="view_absence_data.depart_phones"
          @handleModalClose="handleModalClose"
        />
      </template>
    </Modal>
  </Layout>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import Datepicker from "vuejs3-datepicker";
import AbsencePhoneDetails from "./AbsencePhoneDetails";
import AppButton from "../../shared/AppButton";
import OptionElementInput from "../../shared/OptionElementInput";
import HandleMsg from "../../shared/HandleMsg";
import LoadingIndicator from "../../shared/LoadingIndicator";
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";
import Accordion from "../../shared/Accordion";
import Modal from "../../shared/Modal";
import {
  toSqlDatetime,
  returnSortOptionArray,
  returnCurrentDate,
  returnFormattedDate,
  checkDateDiff,
  returnAllStrAfterFirstChar,
  returnFirstPartOfStrAfterChar,
  returnSystemErrorMsg,
} from "../../helper/util";
import axios from "../../api/axios";

const current_date = returnCurrentDate(false);
const lower_limit = ref(new Date(current_date.getFullYear() + "-" + 1 + "-" + 1));
const start_date = ref("");
const end_date = ref("");
const option_select_arr = returnSortOptionArray();
const select_placeholder = "Select...";

const props = defineProps({
  errors: Object,
  view_absence_res: {},
  department_result: {},
});

const view_absence_data = reactive({
  view_absence_res: props.view_absence_res?.data,
  data_length: props.view_absence_res?.data.length,
  custom_err: props.errors?.fail == undefined ? "" : props.errors?.fail,
  is_sorting: false,
  option_selected: "Latest",
  selected_department_id: select_placeholder,
  work_related: "",
  is_fetching_data_complete: false,
  show_search_wrapperdiv: false,
  co_worker_name: "",
  start_date_error: false,
  end_date_error: false,
  is_date_changed: false,
  is_searching: false,
  is_paginating: false,
  total_records: props.view_absence_res?.total,
  current_records_on_page: props.view_absence_res?.data.length,
  current_active_accordion_index: null,
  absence_being_edited_obj: {},
  absence_being_edited_index: "",
  is_editing_absence: false,
  show_modal: false,
  depart_phones: [],
  co_workers: [],
  depart_phone_cowokers_fetched: false,
  responsible_told: select_placeholder,
  absence_updated_success: "",
  absence_updated_error: "",
  is_phones_div_opened: false,
});

const resetWorkRelated = () => {
  view_absence_data.work_related = "";
};

const handleUpdateAbsenceBtn = () => {
  view_absence_data.is_editing_absence = true;

  setTimeout(async () => {
    const formatted_date_time = returnFormattedDate(
      view_absence_data.absence_being_edited_obj.created_at,
      true
    );

    const obj_to_send = {
      responsible_told: view_absence_data.responsible_told,
      date_called: returnFirstPartOfStrAfterChar(formatted_date_time),
      time_called: returnAllStrAfterFirstChar(formatted_date_time),
      date_absence_for: view_absence_data.absence_being_edited_obj.date_for,
      shift_start_time: view_absence_data.absence_being_edited_obj.shift_start_time,
      shift_end_time: view_absence_data.absence_being_edited_obj.shift_end_time,
      ref_number: view_absence_data.absence_being_edited_obj.ref_number,
      work_related: view_absence_data.absence_being_edited_obj.work_related,
      reason: view_absence_data.absence_being_edited_obj.reason,
      co_worker_name: view_absence_data.absence_being_edited_obj.co_worker_name,
      comment: view_absence_data.absence_being_edited_obj.comment,
      department: view_absence_data.absence_being_edited_obj.department_name,
      absence_id: view_absence_data.absence_being_edited_obj.id,
    };

    try {
      const res = await axios.post("/update-absence-responsible-told", obj_to_send);
      // console.log(res);
      if (res?.data?.error != "") {
        view_absence_data.absence_updated_error = res.data.error;
      } else {
        view_absence_data.absence_updated_success = "Absence update successful";

        setTimeout(() => {
          view_absence_data.absence_updated_success = "";
          handleCancleAbsenceBeingEditedBtn();
          view_absence_data.view_absence_res[
            view_absence_data.absence_being_edited_index
          ].responsible_told = res?.data?.success_data.responsible_told;
          view_absence_data.view_absence_res[
            view_absence_data.absence_being_edited_index
          ].responsible_told_by = res?.data?.success_data.responsible_told_by;
        }, 900);
      }
    } catch (err) {
      //console.log(err);
      view_absence_data.absence_updated_error = returnSystemErrorMsg();
    } finally {
      view_absence_data.is_editing_absence = false;
    }
  }, 100);
};

const updateSelectedLeaderOrResponsible = (selected_leader_responsible) => {
  view_absence_data.responsible_told = selected_leader_responsible;
};

const handleTellResponsibleBtn = (absence_index, absence_obj) => {
  view_absence_data.absence_being_edited_obj = absence_obj;
  view_absence_data.absence_being_edited_index = absence_index;
  view_absence_data.is_phones_div_opened = true;

  setTimeout(async () => {
    //check if depart_phone_cowokers has already been fetched
    if (!view_absence_data.depart_phone_cowokers_fetched) {
      view_absence_data.is_editing_absence = true;
      try {
        const res = await axios.post("/get-coworkers-and-phones", {
          department_id: absence_obj.department_id,
        });
        // console.log(res);

        if (res?.data?.error != "") {
          view_absence_data.custom_err = res.data.error;
        } else {
          view_absence_data.depart_phone_cowokers_fetched = true;
          view_absence_data.depart_phones = res?.data?.depart_phones_res;
          view_absence_data.co_workers = res?.data?.co_workers;
        }
      } catch (err) {
        view_absence_data.custom_err = returnSystemErrorMsg();
      } finally {
        view_absence_data.is_editing_absence = false;
      }
    } // end if
  }, 100);
};

const handleCancleAbsenceBeingEditedBtn = () => {
  view_absence_data.absence_being_edited_obj = {};
  view_absence_data.responsible_told = select_placeholder;
  view_absence_data.is_phones_div_opened = false;
};

const toggleSearchWrapperDiv = () => {
  view_absence_data.show_search_wrapperdiv = !view_absence_data.show_search_wrapperdiv;
};

const returnDataToBePost = () => {
  return {
    selected_department_id:
      view_absence_data.selected_department_id == select_placeholder
        ? ""
        : view_absence_data.selected_department_id,
    selected_sort_option: view_absence_data.option_selected,
    co_worker_name: view_absence_data.co_worker_name,
    start_date: start_date.value == "" ? "" : toSqlDatetime(start_date.value),
    end_date: end_date.value == "" ? "" : toSqlDatetime(end_date.value),
    work_related: view_absence_data.work_related,
    is_date_changed: view_absence_data.is_date_changed,
  };
};

const assignDataFromAxiosCall = (isPagnateResult) => {
  view_absence_data.data_length = props.view_absence_res?.data.length;
  view_absence_data.total_records = props.view_absence_res?.total;
  //if paginate result, add else replace.
  if (isPagnateResult) {
    view_absence_data.view_absence_res = [
      ...view_absence_data.view_absence_res,
      ...props.view_absence_res?.data,
    ];
    view_absence_data.current_records_on_page =
      view_absence_data.current_records_on_page + props.view_absence_res?.data.length;
  } else {
    view_absence_data.view_absence_res = props.view_absence_res?.data;
    view_absence_data.current_records_on_page = props.view_absence_res?.data.length;
  }
};

const viewAllAbsence = async () => {
  //view_absence_data.is_fetching_data_complete = false;

  if (view_absence_data.show_search_wrapperdiv) {
    view_absence_data.show_search_wrapperdiv = false;
  }

  router.post("/absence", returnDataToBePost(), {
    onStart: () => {
      view_absence_data.is_fetching_data_complete = false;
    },
    onFinish: () => {
      view_absence_data.is_fetching_data_complete = true;
      if (view_absence_data.is_searching) {
        view_absence_data.is_searching = false;
      }
      if (view_absence_data.is_sorting) {
        view_absence_data.is_sorting = false;
      }
    },
    onSuccess: () => {
      assignDataFromAxiosCall(false);
    },
  });
};
const removeErrorOnSearchForm = (focused_elem) => {
  if (focused_elem == "start_date" && view_absence_data.start_date_error) {
    view_absence_data.start_date_error = false;
  }

  if (focused_elem == "end_date" && view_absence_data.end_date_error) {
    view_absence_data.end_date_error = false;
  }
};

const handleSearchDepartmentSelectOption = async (selected_option) => {
  view_absence_data.selected_department_id = selected_option.id;
};

const handleSearchBtn = () => {
  let abort = false;

  if (start_date.value == "") {
    abort = true;
    view_absence_data.start_date_error = true;
  }

  if (end_date.value == "") {
    abort = true;
    view_absence_data.end_date_error = true;
  }

  if (!abort) {
    view_absence_data.is_date_changed = true;
    view_absence_data.is_searching = true;
    view_absence_data.current_records_on_page = 0;
    view_absence_data.option_selected = "Latest";
    removeErrorOnSearchForm();
    viewAllAbsence();
  }
};

const handleTodayDepartmentBtn = (department_id, department_absence_total) => {
  if (department_absence_total > 0) {
    view_absence_data.selected_department_id = department_id;
    view_absence_data.is_searching = true;
    view_absence_data.current_records_on_page = 0;
    view_absence_data.option_selected = "Latest";
    view_absence_data.is_date_changed = true;
    start_date.value = current_date;
    end_date.value = current_date;
    viewAllAbsence();
  }
};

const handleSortSelectOption = async (selected_sort_option) => {
  view_absence_data.is_sorting = true;
  view_absence_data.option_selected = selected_sort_option;
  view_absence_data.current_records_on_page = 0;
  viewAllAbsence();
};

const getAllRecords = () => {
  router.visit("/absence", { method: "get" });
};

const handleLoadMoreResult = async () => {
  if (!view_absence_data.is_searching) {
    if (props.view_absence_res?.next_page_url === null) {
      return;
    }

    router.post(props.view_absence_res?.next_page_url, returnDataToBePost(), {
      preserveState: true,
      preserveScroll: true,
      only: ["view_absence_res"],
      onStart: () => {
        view_absence_data.is_paginating = true;
      },
      onFinish: () => {
        view_absence_data.is_paginating = false;
      },
      onSuccess: () => {
        window.history.replaceState({}, "", props.view_absence_res?.path);
        assignDataFromAxiosCall(true);
      },
    });
  } // end if !view_absence_data.is_searching
};

const returnTotalRecordsMsg = () => {
  let record_word = "record";

  if (view_absence_data.total_records > 1) {
    record_word = "records";
  }
  return (
    view_absence_data.current_records_on_page +
    " of " +
    view_absence_data.total_records +
    " total " +
    record_word
  );
};

const handleShowPhones = () => {
  view_absence_data.show_modal = true;
};
const handleModalClose = () => {
  view_absence_data.show_modal = false;
};
</script>
