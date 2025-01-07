<template>
  <Layout
    pageTitle="view-edit-department-company"
    pageIntro="View or Edit department/company"
  >
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="4" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <section v-if="view_depart_comp_data.custom_err != ''">
              <div class="row">
                <div class="col-md-12">
                  <HandleMsg
                    infotype="error"
                    customClass="form-responds-msg text-center"
                    :msg="view_depart_comp_data.custom_err"
                  />
                </div>
              </div>
            </section>
            <section v-else>
              <!-- Total co-workers by departments goes here -->
              <CoWorkersByDepartments
                :depart_coworker_count_result="depart_coworker_count_result"
              />
              <div class="row">
                <div class="col-md-6">
                  <input
                    v-model="search_word"
                    type="text"
                    class="form-control"
                    placeholder="Search department or company..."
                    maxlength="255"
                    autocomplete="off"
                    @keypress.enter.prevent
                  />
                  <!-- col-md-6 -->
                </div>
                <div class="col-md-6">
                  <OptionElementInput
                    :defaultOptionSelected="view_depart_comp_data.option_selected"
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
              <div
                v-if="
                  view_depart_comp_data.is_searching || view_depart_comp_data.is_sorting
                "
                class="row"
              >
                <div class="col-md-12 pt-3">
                  <LoadingIndicator />
                </div>
                <!-- end row -->
              </div>
              <div v-else>
                <div class="row">
                  <div class="col-md-12">
                    <span class="small">{{ returnTotalRecordsMsg() }}</span>
                    <hr class="mt-1 mb-3" />
                  </div>
                </div>
                <div
                  v-show="view_depart_comp_data.data_length > 0"
                  v-for="(
                    depart_comp, index
                  ) in view_depart_comp_data.view_depart_comp_res"
                  class="mb-3"
                  :key="index"
                >
                  <div class="row">
                    <div
                      v-show="returnIfDeleteDepartCompErr(depart_comp.id)"
                      class="col-md-12"
                    >
                      <p class="p-0 m-0 small text-danger">
                        {{ view_depart_comp_data.delete_error }}
                      </p>
                    </div>
                  </div>
                  <div
                    v-show="!checkIfEditFormIsActive(depart_comp.id)"
                    class="row box-shadow mb-4"
                  >
                    <div class="col-md-4">
                      <ul class="result-detail-ul pl-0">
                        <li>
                          {{
                            depart_comp.is_depart_or_comp == 0
                              ? "Department name:"
                              : "Company name:"
                          }}
                          <span>{{ depart_comp.name }}</span>
                        </li>
                        <li>
                          {{
                            depart_comp.is_depart_or_comp == 0
                              ? "Department email:"
                              : "Company email:"
                          }}
                          <span>{{
                            depart_comp.email === null ? "---" : depart_comp.email
                          }}</span>
                        </li>
                        <li>
                          Created on:
                          <span>{{
                            returnFormattedDate(depart_comp.created_at, true)
                          }}</span>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-4">
                      <ul class="result-detail-ul pl-0">
                        <li>
                          Added by:
                          <span>{{
                            returnCoWorkerFullName(
                              depart_comp.created_f_name,
                              depart_comp.created_l_name
                            )
                          }}</span>
                        </li>
                        <li>
                          Updated on:
                          <span>{{
                            depart_comp.updated_at === null
                              ? "---"
                              : returnFormattedDate(depart_comp.updated_at, true)
                          }}</span>
                        </li>

                        <li>
                          Updated by:
                          <span>{{
                            depart_comp.updated_f_name == null
                              ? "---"
                              : returnCoWorkerFullName(
                                  depart_comp.updated_f_name,
                                  depart_comp.updated_l_name
                                )
                          }}</span>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-4 pb-3 pt-3">
                      <!-- start edit and delete btn -->

                      <span
                        v-show="!returnIfDeleteDepartCompIsDeleting(depart_comp.id)"
                        class="mr-2 mb-2"
                      >
                        <AppButton
                          :hideBtn="
                            returnIfDeleteDepartCompIsDeleting(depart_comp.id) ||
                            returnIfDeleteDepartCompSuccess(depart_comp.id)
                          "
                          customClass="btn-primary"
                          :btnFunc="() => handleEditBtn(depart_comp.id)"
                        >
                          <span><i class="fas fa-edit"></i></span>
                        </AppButton>
                      </span>
                      <span>
                        <AppButton
                          :btnStyle="
                            returnIfDeleteDepartCompIsDeleting(depart_comp.id)
                              ? 'secondary'
                              : returnIfDeleteDepartCompSuccess(depart_comp.id)
                              ? 'success'
                              : 'danger'
                          "
                          :btnFunc="
                            () =>
                              handleDeleteDepartCompBtn(
                                depart_comp.id,
                                depart_comp.name,
                                depart_comp.is_depart_or_comp
                              )
                          "
                        >
                          <span v-if="returnIfDeleteDepartCompIsDeleting(depart_comp.id)"
                            >One sec...</span
                          >
                          <span
                            v-else-if="returnIfDeleteDepartCompSuccess(depart_comp.id)"
                            >Success</span
                          >
                          <span v-else><i class="fas fa-trash"></i></span>
                        </AppButton>
                      </span>
                      <!-- end edit and delete btn -->
                    </div>

                    <!-- end row -->
                  </div>

                  <!-- EDIT FORM GOES HERE -->

                  <div v-show="checkIfEditFormIsActive(depart_comp.id)" class="pb-4">
                    <EditDepartmentOrCompanyForm
                      :depart_comp="depart_comp"
                      :depart_comp_index="index"
                      @updateDepartCompBeingEdited="handleUpdateDepartCompBeingEdited"
                    />
                  </div>
                  <!-- 
                  <div class="pt-2">
                    <hr class="m-0" />
                  </div> -->
                </div>

                <div
                  v-show="view_depart_comp_prop_res?.next_page_url != null"
                  class="row pt-3"
                >
                  <div class="col-md-6 mx-auto">
                    <AppButton
                      customClass="primary-btn"
                      :btnFunc="handleLoadMoreResult"
                      :fullBtn="true"
                    >
                      <span v-if="view_depart_comp_data.is_paginating">
                        <LoadingIndicator loaderSize="small" :showBelowText="false" />
                      </span>
                      <span v-else> Load more </span>
                    </AppButton>
                  </div>

                  <!-- end row -->
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
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
import LoadingIndicator from "../../shared/LoadingIndicator";
import EditDepartmentOrCompanyForm from "./EditDepartmentOrCompanyForm";
import CoWorkersByDepartments from "./CoWorkersByDepartments";
import {
  returnFormattedDate,
  returnCoWorkerFullName,
  scrollToTopOrBottomOfPage,
  returnSystemErrorMsg,
} from "../../helper/util";
import axios from "../../api/axios";
import { debounce } from "lodash";

const search_word = ref("");
const option_select_arr = ["Latest", "Department", "Company", "A-Z", "Z-A"];

const props = defineProps({
  errors: Object,
  view_depart_comp_prop_res: {},
  depart_coworker_count_result: {},
});

const view_depart_comp_data = reactive({
  view_depart_comp_res: props.view_depart_comp_prop_res?.data,
  data_length: props.view_depart_comp_prop_res?.data.length,
  total_records: props.view_depart_comp_prop_res?.total,
  is_sorting: false,
  option_selected: option_select_arr[0],
  custom_err: props.errors?.fail == undefined ? "" : props.errors?.fail,
  is_searching: false,
  is_paginating: false,

  current_records_on_page: props.view_depart_comp_prop_res?.data.length,
  //Edit data
  depart_comp_being_edited_id: 0,
  //DELETE DATA
  depart_comp_being_deleted_id: 0,
  is_deleting: false,
  is_deleted: false,
  delete_success: "",
  delete_error: "",
});

//DELETE FUNCTIONS
const handleDeleteDepartCompBtn = (
  depart_comp_id,
  depart_comp_name,
  is_depart_or_comp
) => {
  view_depart_comp_data.delete_error = "";
  let depart_or_comp = "department";

  if (is_depart_or_comp === 1) {
    depart_or_comp = "company";
  }
  if (
    window.confirm(
      `Delete ${
        depart_or_comp + " " + depart_comp_name
      }? please note this can not be undone, all phones connect to ${depart_comp_name} will be deleted as well thank you.`
    )
  ) {
    view_depart_comp_data.is_deleted = false;
    view_depart_comp_data.is_deleting = true;
    view_depart_comp_data.depart_comp_being_deleted_id = depart_comp_id;

    setTimeout(async () => {
      try {
        const res = await axios.post("/depart-comp/delete", {
          depart_comp_id: depart_comp_id,
          depart_or_comp: depart_or_comp,
          depart_comp_name: depart_comp_name,
        });
        //res.data.outcome can be boolean or error message
        if (res?.data?.error == "") {
          //set success msg
          view_depart_comp_data.delete_success = "Success";
          view_depart_comp_data.is_deleted = true;
          setTimeout(() => {
            router.get("/view-all-depart-comp");
          }, 700);
        } else {
          //Set error meg
          view_depart_comp_data.delete_error = res?.data?.error;
          //console.log("PHONE ERROR =>", res.data.outcome);
        }
      } catch (err) {
        view_depart_comp_data.delete_error = returnSystemErrorMsg();
        //console.log("ERR =>", err);
      } finally {
        view_depart_comp_data.is_deleting = false;
      }
    }, 1500);
  } // end window confirm
};

const returnIfDeleteDepartCompIsDeleting = (depart_comp_id) => {
  let deleting = false;
  if (
    view_depart_comp_data.is_deleting &&
    view_depart_comp_data.depart_comp_being_deleted_id == depart_comp_id
  ) {
    return (deleting = true);
  }

  return deleting;
};

const returnIfDeleteDepartCompSuccess = (depart_comp_id) => {
  let success = false;
  if (
    view_depart_comp_data.is_deleted &&
    view_depart_comp_data.delete_success != "" &&
    view_depart_comp_data.depart_comp_being_deleted_id == depart_comp_id
  ) {
    success = true;
  }
  return success;
};

const returnIfDeleteDepartCompErr = (depart_comp_id) => {
  let err = false;
  if (
    view_depart_comp_data.delete_error != "" &&
    view_depart_comp_data.depart_comp_being_deleted_id == depart_comp_id
  ) {
    err = true;
  }
  return err;
};

//EDIT FUNCTIONS
const handleEditBtn = (depart_comp_id) => {
  view_depart_comp_data.depart_comp_being_edited_id = depart_comp_id;
  view_depart_comp_data.delete_error = "";
};
const checkIfEditFormIsActive = (depart_comp_id) => {
  let editing = false;
  if (view_depart_comp_data.depart_comp_being_edited_id == depart_comp_id) {
    editing = true;
  }

  return editing;
};

const handleUpdateDepartCompBeingEdited = (data_obj) => {
  view_depart_comp_data.depart_comp_being_edited_id = 0;

  if (data_obj.action == "success") {
    //If action is success
    view_depart_comp_data.view_depart_comp_res[data_obj.depart_comp_index].updated_at =
      data_obj.updated_date;
    view_depart_comp_data.view_depart_comp_res[
      data_obj.depart_comp_index
    ].updated_f_name = data_obj.updated_by_fname;
    view_depart_comp_data.view_depart_comp_res[
      data_obj.depart_comp_index
    ].updated_l_name = data_obj.updated_by_lname;
    view_depart_comp_data.view_depart_comp_res[data_obj.depart_comp_index].name =
      data_obj.name;
    view_depart_comp_data.view_depart_comp_res[data_obj.depart_comp_index].email =
      data_obj.email;
    view_depart_comp_data.view_depart_comp_res[
      data_obj.depart_comp_index
    ].is_depart_or_comp = data_obj.is_company;
    view_depart_comp_data.view_depart_comp_res[
      data_obj.depart_comp_index
    ].is_quick_company = data_obj.is_quick;
  } // end data_obj.action
};
//VIEW FUNCTIONS

const assignDataFromAxiosApiCall = (isPagnateResult) => {
  view_depart_comp_data.data_length = props.view_depart_comp_prop_res?.data.length;
  view_depart_comp_data.total_records = props.view_depart_comp_prop_res?.total;
  //if paginate result, add else replace.
  if (isPagnateResult) {
    view_depart_comp_data.view_depart_comp_res = [
      ...view_depart_comp_data.view_depart_comp_res,
      ...props.view_depart_comp_prop_res?.data,
    ];
    view_depart_comp_data.current_records_on_page =
      view_depart_comp_data.current_records_on_page +
      props.view_depart_comp_prop_res?.data.length;
  } else {
    view_depart_comp_data.view_depart_comp_res = props.view_depart_comp_prop_res?.data;
    view_depart_comp_data.current_records_on_page =
      props.view_depart_comp_prop_res?.data.length;
  }
};

const returnDataToBePost = () => {
  return {
    option_selected: view_depart_comp_data.option_selected,
    searched_word: search_word.value,
  };
};

const handleLoadMoreResult = async () => {
  if (!view_depart_comp_data.is_searching) {
    if (props.view_depart_comp_prop_res?.next_page_url === null) {
      return;
    }

    router.post(props.view_depart_comp_prop_res?.next_page_url, returnDataToBePost(), {
      preserveState: true,
      preserveScroll: true,
      only: ["view_depart_comp_prop_res"],
      onStart: () => {
        view_depart_comp_data.is_paginating = true;
      },
      onFinish: () => {
        view_depart_comp_data.is_paginating = false;
      },
      onSuccess: () => {
        window.history.replaceState({}, "", props.view_depart_comp_prop_res?.path);
        scrollToTopOrBottomOfPage("bottom");
        assignDataFromAxiosApiCall(true);
      },
    });
  } // end if !view_depart_comp_data.is_searching
};

const returnTotalRecordsMsg = () => {
  let record_word = "record";

  if (view_depart_comp_data.total_records > 1) {
    record_word = "records";
  }
  return (
    view_depart_comp_data.current_records_on_page +
    " of " +
    view_depart_comp_data.total_records +
    " total " +
    record_word
  );
};

const getDepartCompApiCall = async () => {
  router.post("/view-all-depart-comp", returnDataToBePost(), {
    onFinish: () => {
      if (view_depart_comp_data.is_searching) {
        view_depart_comp_data.is_searching = false;
      }
      if (view_depart_comp_data.is_sorting) {
        view_depart_comp_data.is_sorting = false;
      }
    },
    onSuccess: () => {
      assignDataFromAxiosApiCall(false);
    },
  });
};

const handleSearchForm = () => {
  view_depart_comp_data.is_searching = true;
  view_depart_comp_data.current_records_on_page = 0;
  view_depart_comp_data.option_selected = option_select_arr[0];
  getDepartCompApiCall();
};

const handleSortSelectOption = async (selected_sort_option) => {
  view_depart_comp_data.is_sorting = true;
  view_depart_comp_data.option_selected = selected_sort_option;
  view_depart_comp_data.current_records_on_page = 0;
  getDepartCompApiCall();
};

//Watch the search input value for changes.
watch(
  search_word,
  debounce(() => {
    handleSearchForm();
  }, 400)
);
</script>
