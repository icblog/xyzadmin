<template>
  <Layout pageTitle="add-absence" pageIntro="Add absence">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="2" />
            <!-- end col-lg-3 side bar-->
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="form-wrapper">
              <section v-show="addAbsentData.is_add_absence_form_processing">
                <LoadingIndicator />
              </section>
              <section v-show="!addAbsentData.is_add_absence_form_processing">
                <HandleMsg
                  v-if="addAbsentData.custom_err != ''"
                  infotype="error"
                  :msg="addAbsentData.custom_err"
                  customClass="form-responds-msg"
                />

                <div v-else-if="addAbsentData.custom_success != ''">
                  <HandleMsg
                    infotype="success"
                    :msg="addAbsentData.custom_success"
                    customClass="form-responds-msg"
                  />

                  <AfterSuccessBtn
                    add_link_name="/absence/add"
                    redirect_link_name="/absence"
                    click_action_add="add_another"
                    click_action_redirect="view_absence"
                    add_btn_name="Add another absence"
                    redirect_btn_name="View absence"
                    @updateSuccessCancelTimer="updateSuccessCancelTimer"
                  />
                </div>

                <form v-else @submit.prevent="handleAbsenceForm">
                  <section v-if="addAbsentData.formData.co_worker_name == ''">
                    <p class="small">
                      Step <span class="bolded">1 of 3</span><br />
                      Find the co-worker and click on their name.
                    </p>
                    <label class="form-label" for="coworker-name">Co-worker name* </label>
                    <CoWorkerSearch
                      :makeResultAlink="false"
                      end_point="/absence/find-user"
                      resultFoundTextSingular="person"
                      resultFoundTextplural="people"
                      noResultText="Sorry no one found, try again thank you."
                      @updateSelected="updateSelectedCoworker"
                    />
                  </section>
                  <section v-else>
                    <div class="row">
                      <div class="col-md-12">
                        <p v-if="addAbsentData.is_next_btn_clicked" class="small">
                          Step <span class="bolded">3 of 3</span><br />
                          Add optional comment, contact department leader or responsible
                          and if there is no answer, save the form anyway as this can be
                          updated later when someone become available.
                        </p>
                        <p v-else class="small">
                          Step <span class="bolded">2 of 3</span><br />
                          Type or select a reason for absence and indicate if it's work
                          related, comment is optional.
                        </p>
                        <hr class="m-0 p-0" />
                        <!-- end col-md-12-->
                      </div>
                      <!-- end row-->
                    </div>

                    <section>
                      <div class="row">
                        <div class="col-md-6 pt-1">
                          <div
                            v-show="
                              addAbsentData.formData.ref_number != '' &&
                              addAbsentData.formData.co_worker_name != ''
                            "
                          >
                            <label class="form-label"> Reference: </label>
                            <p class="selected-p">
                              {{ " " + addAbsentData.formData.ref_number }}
                            </p>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <div v-if="addAbsentData.formData.co_worker_name != ''">
                              <label class="form-label" for="coworker-name">
                                Co-worker name:
                              </label>
                              <p class="selected-p">
                                <span class="pr-3">
                                  {{ addAbsentData.formData.co_worker_name }}</span
                                >
                              </p>
                            </div>
                          </div>
                          <!-- end div col-md-6 -->
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <div v-if="addAbsentData.formData.department != ''">
                              <label class="form-label" for="coworker-name">
                                Department:
                              </label>
                              <p class="selected-p">
                                {{ addAbsentData.formData.department }}
                              </p>
                            </div>
                          </div>
                          <!-- end div col-md-6 -->
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <div v-if="addAbsentData.is_next_btn_clicked">
                              <label class="form-label" for="coworker-name">
                                Reason:
                              </label>
                              <p class="selected-p">
                                {{ addAbsentData.formData.reason_option_selected_value }}
                              </p>
                            </div>
                            <div v-else>
                              <OptionElementInput
                                v-if="absence_common_reason_res.length > 0"
                                labelName="Reason*"
                                :inputErrMsg="addAbsentData.errors.reason_err"
                                :defaultOptionSelected="
                                  addAbsentData.formData.reason_option_selected_value
                                "
                                :disabledInput="false"
                                :resultObj="absence_common_reason_res"
                                :inputFocusFunc="() => removeAddAbsenceFormErr('reason')"
                                @updateSelectedOptionInput="updateReasonSelected"
                              />
                            </div>
                          </div>
                          <!-- end div col-md-6 -->
                        </div>

                        <div class="col-md-12 pb-2 pt-2">
                          <hr class="m-0 p-0" />
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label" for="coworker-name">
                              Work related{{
                                addAbsentData.is_next_btn_clicked ? ":" : "*"
                              }}
                            </label>
                            <p
                              v-if="addAbsentData.is_next_btn_clicked"
                              class="selected-p"
                            >
                              {{ addAbsentData.formData.work_related }}
                            </p>
                            <div v-else>
                              <div
                                class="text-danger small"
                                v-if="addAbsentData.errors.work_related_err != ''"
                              >
                                {{ addAbsentData.errors.work_related_err }}
                              </div>

                              <div class="form-check-inline">
                                <span class="form-check-label">
                                  <input
                                    type="radio"
                                    class="form-check-input"
                                    id="no"
                                    value="No"
                                    v-model="addAbsentData.formData.work_related"
                                    @click="() => removeAddAbsenceFormErr('work_related')"
                                  />No
                                </span>
                              </div>
                              <div class="form-check-inline">
                                <span class="form-check-label">
                                  <input
                                    type="radio"
                                    class="form-check-input"
                                    id="yes"
                                    value="Yes"
                                    v-model="addAbsentData.formData.work_related"
                                    @click="() => removeAddAbsenceFormErr('work_related')"
                                  />Yes
                                </span>
                              </div>
                            </div>
                          </div>
                          <!-- end div col-md-6 -->
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label" for="coworker-name"
                              >Date absent is for{{
                                addAbsentData.is_next_btn_clicked ? ":" : "*"
                              }}
                            </label>

                            <div
                              class="text-danger small"
                              v-show="
                                addAbsentData.errors.date_for_err != '' &&
                                !addAbsentData.is_next_btn_clicked
                              "
                            >
                              {{ addAbsentData.errors.date_for_err }}
                            </div>
                            <div v-if="addAbsentData.is_next_btn_clicked">
                              {{
                                returnFormattedDate(
                                  addAbsentData.formData.date_absence_for
                                )
                              }}
                            </div>

                            <div
                              v-else
                              @click="() => removeAddAbsenceFormErr('date_for')"
                            >
                              <Datepicker
                                v-model="addAbsentData.selected_absence_for_date"
                                format="dd/MM/yyyy"
                                placeholder="Pick a date"
                                :disabled-dates="{
                                  to: lower_limit,
                                }"
                                :prevent-disable-date-selection="true"
                              >
                              </Datepicker>
                            </div>
                          </div>
                          <!-- end div col-md-6 -->
                        </div>
                        <!-- end row-->
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label" for="shift-start-time"
                              >Shift start{{
                                addAbsentData.is_next_btn_clicked ? ":" : "*"
                              }}
                            </label>
                            <p
                              v-if="addAbsentData.is_next_btn_clicked"
                              class="selected-p"
                            >
                              {{ addAbsentData.formData.shift_start_time }}
                            </p>
                            <div v-else>
                              <div
                                v-show="addAbsentData.errors.shift_start_time_err != ''"
                                class="small text-danger"
                              >
                                {{ addAbsentData.errors.shift_start_time_err }}
                              </div>
                              <TimeInput
                                :default_time="addAbsentData.formData.shift_start_time"
                                @updateTimeValue="
                                  (shift_time) =>
                                    updateShiftTime(shift_time, 'start-time')
                                "
                                :inputFocusFunc="
                                  () => removeAddAbsenceFormErr('start_time')
                                "
                              />
                            </div>
                          </div>
                          <!-- end div col-md-6 -->
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label" for="shift-end-time"
                              >Shift end{{
                                addAbsentData.is_next_btn_clicked ? ":" : "*"
                              }}
                            </label>
                            <p
                              v-if="addAbsentData.is_next_btn_clicked"
                              class="selected-p"
                            >
                              {{ addAbsentData.formData.shift_end_time }}
                            </p>
                            <div v-else>
                              <div
                                v-show="addAbsentData.errors.shift_end_time_err != ''"
                                class="small text-danger"
                              >
                                {{ addAbsentData.errors.shift_end_time_err }}
                              </div>
                              <TimeInput
                                :default_time="addAbsentData.formData.shift_end_time"
                                @updateTimeValue="
                                  (shift_time) => updateShiftTime(shift_time, 'end-time')
                                "
                                :inputFocusFunc="
                                  () => removeAddAbsenceFormErr('end_time')
                                "
                              />
                            </div>
                          </div>
                          <!-- end div col-md-6 -->
                        </div>

                        <!-- end row-->
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <hr class="m-0 p-0 pt-2 pb-2" />
                          <div class="form-group">
                            <label class="form-label"
                              >Comment{{ addAbsentData.is_next_btn_clicked ? ":" : "" }}
                              <span
                                v-show="!addAbsentData.is_next_btn_clicked"
                                class="optional"
                                >(Optional)</span
                              >
                            </label>
                            <div v-if="addAbsentData.is_next_btn_clicked">
                              {{
                                addAbsentData.formData.comment == ""
                                  ? "None"
                                  : addAbsentData.formData.comment
                              }}
                            </div>
                            <div v-else>
                              <textarea
                                v-model="addAbsentData.formData.comment"
                                class="form-control"
                                rows="1"
                                cols="10"
                              ></textarea>
                            </div>
                          </div>
                        </div>

                        <!-- end row-->
                      </div>
                      <div v-show="!addAbsentData.is_next_btn_clicked" class="row pt-2">
                        <div class="col-md-12">
                          <hr class="m-0 p-0" />
                        </div>
                        <div class="col-md-12 pt-2">
                          <p class="small">All fields marked with a * are mandatory</p>
                        </div>
                        <div class="col-md-6 pb-3">
                          <AppButton
                            :btnFunc="() => handleBackBtnClick('goto-step1')"
                            customClass="change-selected-btn"
                          >
                            Go back
                          </AppButton>
                        </div>
                        <div class="col-md-6">
                          <AppButton
                            :fullBtn="true"
                            :btnFunc="handleNextBtn"
                            customClass="primary-btn"
                          >
                            Next
                          </AppButton>
                        </div>
                        <!-- end row-->
                      </div>
                    </section>
                    <section v-show="addAbsentData.is_next_btn_clicked">
                      <div class="row pt-2">
                        <div class="col-md-12 pb-2">
                          <hr class="m-0 p-0" />
                        </div>
                        <div class="col-md-6 pt-5">
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
                              v-if="addAbsentData.co_workers.length > 0"
                              labelName="Co-workers/leaders"
                              :defaultOptionSelected="
                                addAbsentData.formData.responsible_told
                              "
                              :disabledInput="true"
                              arrType="arr"
                              :resultObj="addAbsentData.co_workers"
                              @updateSelectedOptionInput="
                                updateSelectedLeaderOrResponsible
                              "
                            />
                          </div>
                          <!-- end div col-md-6 -->
                        </div>
                        <!-- end row-->
                      </div>

                      <div class="row pt-2">
                        <div class="col-md-12 pb-3">
                          <hr class="m-0 p-0" />
                          <p class="small">
                            If
                            <span class="bolded"
                              >{{ addAbsentData.formData.department }} department</span
                            >
                            answer, select a responsible and click save. if no answer
                            click save you can informed the responsible later.
                          </p>
                          <HandleMsg
                            v-show="addAbsentData.save_err"
                            infotype="error"
                            msg="Error has occured, click the go back button  below to correct them thanks."
                            customClass="form-responds-msg small"
                          />
                          <input
                            v-model="addAbsentData.formData.myhouse"
                            type="text"
                            maxlength="2"
                            name="myhouse"
                            class="not_in_my_house"
                          />
                        </div>

                        <div class="col-md-6 pb-3">
                          <AppButton
                            :btnFunc="() => handleBackBtnClick('goto-step2')"
                            customClass="change-selected-btn"
                          >
                            Go back
                          </AppButton>
                        </div>
                        <div class="col-md-6">
                          <AppButton
                            :btnFunc="handleAbsenceForm"
                            customClass="primary-btn"
                            :fullBtn="true"
                          >
                            Save
                          </AppButton>
                        </div>
                        <!-- end row-->
                      </div>
                    </section>
                  </section>
                </form>
              </section>
              <!-- end form wrapper-->
            </div>
            <!-- end col-lg-9 main-->
          </div>

          <!-- end row-->
        </div>
        <!-- end container -->
      </div>
      <!-- end container wrapper -->
    </div>
    <!-- MODAL GOES HERE -->
    <Modal :showModal="addAbsentData.show_modal" :showCloseBtn="false">
      <template v-slot:c-modal-content>
        <AbsencePhoneDetails
          v-if="addAbsentData.depart_phone_cowokers_fetched"
          :view_phone_res="addAbsentData.depart_phones"
          @handleModalClose="handleModalClose"
        />
      </template>
    </Modal>
  </Layout>
</template>
<script setup>
import { reactive } from "vue";
import Datepicker from "vuejs3-datepicker";
import { router } from "@inertiajs/vue3";
import LoadingIndicator from "../../shared/LoadingIndicator";

import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import AfterSuccessBtn from "../../shared/AfterSuccessBtn";
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";
import OptionElementInput from "../../shared/OptionElementInput";
import CoWorkerSearch from "../../shared/CoWorkerSearch";
import TimeInput from "../../shared/TimeInput";
import Modal from "../../shared/Modal";
import AbsencePhoneDetails from "./AbsencePhoneDetails";
import {
  returnCoWorkerFullName,
  returnRefNumber,
  returnSystemErrorMsg,
  scrollToTopOrBottomOfPage,
  returnReturnMinDateAsToday,
  returnFormattedDate,
  toSqlDatetime,
  returnCurrentTime,
  returnCurrentDate,
} from "../../helper/util";
import axios from "../../api/axios";

const lower_limit = new Date(returnReturnMinDateAsToday());
const props = defineProps({
  absence_common_reason_res: {},
});

const addAbsentData = reactive({
  formData: {
    ref_number: "",
    co_worker_name: "",
    co_worker_email: "",
    department: "",
    department_id: "",
    reason_option_selected_value: "",
    work_related: "",
    date_called: returnCurrentDate(),
    time_called: returnCurrentTime(),
    date_absence_for: "",
    comment: "",
    shift_start_time: "",
    shift_end_time: "",
    responsible_told: "Select....",
    myhouse: "",
  },
  errors: {
    reason_err: "",
    work_related_err: "",
    date_for_err: "",
    shift_start_time_err: "",
    shift_end_time_err: "",
  },
  show_modal: false,
  is_add_absence_form_processing: false,
  custom_err: "",
  custom_success: "",
  depart_phones: {},
  co_workers: [],
  depart_phone_cowokers_fetched: false,
  is_next_btn_clicked: false,
  is_go_to_backbtn2_clicked: false,
  selected_absence_for_date: "",
  save_err: false,
  cancel_success_timer: false,
});

const handleShowPhones = () => {
  addAbsentData.show_modal = true;
};
const handleModalClose = () => {
  addAbsentData.show_modal = false;
};

const updateSuccessCancelTimer = () => {
  addAbsentData.cancel_success_timer = true;
};

const removeAddAbsenceFormErr = (focused_input) => {
  if (focused_input == "reason") {
    if (addAbsentData.errors.reason_err != "") {
      addAbsentData.errors.reason_err = "";
    }
  }
  if (focused_input == "work_related") {
    if (addAbsentData.errors.work_related_err != "") {
      addAbsentData.errors.work_related_err = "";
    }
  }

  if (focused_input == "date_for") {
    if (addAbsentData.errors.date_for_err != "") {
      addAbsentData.errors.date_for_err = "";
    }
  }

  if (focused_input == "start_time") {
    if (addAbsentData.errors.shift_start_time_err != "") {
      addAbsentData.errors.shift_start_time_err = "";
    }
  }

  if (focused_input == "end_time") {
    if (addAbsentData.errors.shift_end_time_err != "") {
      addAbsentData.errors.shift_end_time_err = "";
    }
  }
};

const assignAddAbsentFormErrMsg = (errors_arr) => {
  errors_arr.forEach((error) => {
    if (error.toLowerCase().indexOf("reason") > -1) {
      addAbsentData.errors.reason_err = error;
    }
    if (error.toLowerCase().indexOf("work related") > -1) {
      addAbsentData.errors.work_related_err = error;
    }

    if (error.toLowerCase().indexOf("date") > -1) {
      addAbsentData.errors.date_for_err = error;
    }

    if (error.toLowerCase().indexOf("start time") > -1) {
      addAbsentData.errors.shift_start_time_err = error;
    }

    if (error.toLowerCase().indexOf("end time") > -1) {
      addAbsentData.errors.shift_end_time_err = error;
    }
  });
};

const handleAbsenceForm = () => {
  scrollToTopOrBottomOfPage();
  setTimeout(async () => {
    try {
      addAbsentData.is_add_absence_form_processing = true;
      const res = await axios.post("/absence/store", addAbsentData.formData);

      if (res?.data?.errors.length > 0) {
        scrollToTopOrBottomOfPage("bottom");
        setTimeout(() => {
          assignAddAbsentFormErrMsg(res?.data?.errors);
          addAbsentData.save_err = true;
        }, 100);
      } else {
        //success
        addAbsentData.custom_success = "Absence info successfully saved thank you";
        setTimeout(() => {
          if (!addAbsentData.cancel_success_timer) {
            router.get("/");
          }
        }, 10000);
      }
    } catch (err) {
      addAbsentData.custom_err = returnSystemErrorMsg();
    } finally {
      addAbsentData.is_add_absence_form_processing = false;
    }
  }, 100);
};

const changeCoworker = () => {
  scrollToTopOrBottomOfPage();
  setTimeout(() => {
    addAbsentData.formData.co_worker_name = "";
    addAbsentData.ref_number = "";
    addAbsentData.is_next_btn_clicked = false;
  }, 100);
};
const clearOldAddAdsenceFormData = () => {
  addAbsentData.formData.responsible_told = "Select...";
  addAbsentData.is_next_btn_clicked = false;
};

const handleBackBtnClick = (step_to_go_to) => {
  scrollToTopOrBottomOfPage();
  setTimeout(() => {
    if (step_to_go_to == "goto-step1") {
      addAbsentData.is_go_to_backbtn2_clicked = false;
      changeCoworker();
    } else if (step_to_go_to == "goto-step2") {
      clearOldAddAdsenceFormData();
      addAbsentData.is_go_to_backbtn2_clicked = true;
      addAbsentData.save_err = false;
    }
  }, 100);
};

const getCoworkersAndPhones = async () => {
  //check if depart_phone_cowokers has already been fetched
  if (!addAbsentData.depart_phone_cowokers_fetched) {
    try {
      const res = await axios.post("/get-coworkers-and-phones", {
        department_id: addAbsentData.formData.department_id,
      });
      // console.log(res);

      if (res?.data?.error != "") {
        addAbsentData.custom_err = res.data.error;
      } else {
        addAbsentData.depart_phone_cowokers_fetched = true;
        addAbsentData.depart_phones = res?.data?.depart_phones_res;
        addAbsentData.co_workers = res?.data?.co_workers;
        addAbsentData.formData.department = res?.data?.depart_name.name;
      }
    } catch (err) {
      addAbsentData.custom_err = returnSystemErrorMsg();
    }
  } // end if
};

const updateSelectedCoworker = (selected_coworker) => {
  addAbsentData.formData.ref_number = returnRefNumber(
    selected_coworker.fname,
    selected_coworker.lname
  );

  addAbsentData.formData.co_worker_name = returnCoWorkerFullName(
    selected_coworker.fname,
    selected_coworker.lname
  );
  addAbsentData.formData.department_id = selected_coworker.department_company;
  addAbsentData.formData.co_worker_email = selected_coworker.email;
  getCoworkersAndPhones();
};

const updateReasonSelected = (selected_reason) => {
  addAbsentData.formData.reason_option_selected_value = selected_reason;
};

const updateShiftTime = (shift_time, input_name) => {
  if (input_name == "end-time") {
    addAbsentData.formData.shift_end_time = shift_time;
  } else if (input_name == "start-time") {
    addAbsentData.formData.shift_start_time = shift_time;
  }
};

const handleNextBtn = () => {
  let abort = false,
    temp_err = [];
  if (addAbsentData.formData.reason_option_selected_value == "") {
    abort = true;
    temp_err.push("Type or select a reason for absence");
  }

  if (addAbsentData.formData.work_related == "") {
    abort = true;
    temp_err.push("Indicate if work related or not please");
  }

  if (addAbsentData.selected_absence_for_date == "") {
    abort = true;
    temp_err.push("Pick what date the absent is for");
  }

  if (addAbsentData.formData.shift_start_time == "") {
    abort = true;
    temp_err.push("Enter shift start time");
  }

  if (addAbsentData.formData.shift_end_time == "") {
    abort = true;
    temp_err.push("Enter shift end time");
  }

  if (temp_err.length > 0) {
    assignAddAbsentFormErrMsg(temp_err);
    return;
  }

  if (!abort) {
    addAbsentData.is_next_btn_clicked = true;
    addAbsentData.formData.date_absence_for = toSqlDatetime(
      addAbsentData.selected_absence_for_date
    );
  } // end if abort is false
};

const updateSelectedLeaderOrResponsible = (selected_leader_responsible) => {
  addAbsentData.formData.responsible_told = selected_leader_responsible;
};
</script>
