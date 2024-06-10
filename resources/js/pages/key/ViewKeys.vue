<template>
  <Layout pageTitle="Keys" pageIntro="View keys">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="6" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <section v-if="keys_data.custom_err != ''">
              <div class="row">
                <div class="col-md-12">
                  <HandleMsg
                    infotype="error"
                    customClass="form-responds-msg text-center"
                    :msg="keys_data.custom_err"
                  />
                </div>
              </div>
            </section>

            <section v-else>
              <div class="row">
                <div class="col-md-12">
                  <input
                    v-model="search_word"
                    type="text"
                    class="form-control mb-3"
                    placeholder="Search a key by name or description..."
                    maxlength="255"
                    autocomplete="off"
                    @keypress.enter.prevent
                  />
                  <!-- col-md-12 -->
                </div>
                <div class="col-md-6">
                  <OptionElementInput
                    v-if="key_storage_res.length > 0"
                    labelName="By storage"
                    :allowSearch="true"
                    :labelPrepend="true"
                    :defaultOptionSelected="keys_data.storage_name"
                    :resultObj="key_storage_res"
                    :disabledInput="true"
                    whatToget="id"
                    @updateSelectedOptionInput="updateSelectedKeyStorage"
                  />

                  <!-- col-md-6 -->
                </div>

                <div class="col-md-6">
                  <OptionElementInput
                    :defaultOptionSelected="keys_data.option_selected"
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
              <div v-if="keys_data.is_searching || keys_data.is_sorting" class="row">
                <div class="col-md-12 pt-3">
                  <LoadingIndicator />
                </div>
                <!-- end row -->
              </div>
              <!-- //Show results -->
              <div v-else>
                <div class="row">
                  <div class="col-md-12">
                    <span class="small">{{ returnTotalRecordsMsg() }}</span>
                    <hr class="mt-1 mb-3" />
                  </div>
                </div>
                <div
                  v-show="keys_data.data_length > 0"
                  v-for="(key, index) in keys_data.view_keys_res"
                  class="mb-3"
                  :key="index"
                >
                  <div class="row box-shadow mb-4">
                    <div class="col-md-4">
                      <ul class="result-detail-ul pl-0">
                        <li>
                          Name/number:
                          <span class="locker-name-number">{{ key.name }}</span>
                        </li>
                        <li>
                          Description:
                          <span class="locker-name-number">{{ key.description }}</span>
                        </li>
                        <li>
                          Status:

                          <span
                            :class="{
                              'badge font-weight-bold no-border-radius': true,
                              'badge-warning': key.status == 2,
                              'badge-danger': key.status == 1,
                              'badge-success': key.status == 0,
                            }"
                          >
                            {{
                              key.status == 2
                                ? "Broken"
                                : key.status == 1
                                ? "Inuse"
                                : "Free"
                            }}</span
                          >
                        </li>
                        <li>
                          Storage:
                          <span>{{ key.storage_name }}</span>
                        </li>
                        <li>
                          Comment:
                          <span> {{ key.comment == null ? "---" : key.comment }}</span>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-4">
                      <ul class="result-detail-ul pl-0">
                        <li>
                          Added on:
                          <span>{{ returnFormattedDate(key.created_at, true) }}</span>
                        </li>
                        <li>
                          Added by:
                          <span>{{
                            returnCoWorkerFullName(key.created_by_f, key.created_by_l)
                          }}</span>
                        </li>
                        <li>
                          Updated on:
                          <span>{{
                            key.updated_at === null
                              ? "---"
                              : returnFormattedDate(key.updated_at, true)
                          }}</span>
                        </li>

                        <li>
                          Updated by:
                          <span>{{
                            key.updated_by_f == null
                              ? "---"
                              : returnCoWorkerFullName(key.updated_by_f, key.updated_by_l)
                          }}</span>
                        </li>
                      </ul>
                    </div>
                    <div class="col-md-4 pb-4 view-lockers-btn-wrapper">
                      <AppButton
                        customClass="mt-4 mr-2 mb-4"
                        btnStyle="warn"
                        :btnFunc="() => handleModalOpen('view_auth', key)"
                      >
                        <span><i class="fas fa-exclamation"></i></span>
                      </AppButton>
                      <AppLink
                        className="btn-primary btn no-border-radius mr-2"
                        :linkUrl="'/edit-key/' + Number(key.id)"
                      >
                        <span>
                          <i class="fas fa-edit"></i>
                        </span>
                      </AppLink>
                      <AppButton
                        :noBtnStyle="true"
                        :customClassObj="{
                          'mt-4 mb-4': true,
                          'btn no-border-radius btn-danger':
                            key.status == 0 || key.status == 2,
                          'disabled-btn': key.status == 1,
                        }"
                        :btnDisabled="key.status == 1"
                        :btnFunc="() => handleModalOpen('delete', key)"
                      >
                        <span>
                          <i class="fas fa-trash"></i>
                        </span>
                      </AppButton>
                    </div>
                  </div>
                  <!-- end if result -->
                </div>
                <div v-show="view_keys_prop_obj?.next_page_url != null" class="row pt-3">
                  <div class="col-md-6 mx-auto">
                    <AppButton
                      customClass="primary-btn"
                      :btnFunc="handleLoadMoreResult"
                      :fullBtn="true"
                    >
                      <span v-if="keys_data.is_paginating">
                        <LoadingIndicator loaderSize="small" :showBelowText="false" />
                      </span>
                      <span v-else> Load more </span>
                    </AppButton>
                  </div>

                  <!-- end row -->
                </div>
                <!-- end else -->
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL GOES HERE -->
    <Modal :showModal="keys_data.show_modal" :showCloseBtn="false">
      <template v-slot:c-modal-content>
        <section v-show="keys_data.is_view_key_auth_btn_clicked">
          <FetchKeyAuth
            :key_data="keys_data.key_being_actioned"
            :is_go_ahead="keys_data.is_view_key_auth_btn_clicked"
            @handleModalClose="handleModalClose"
          />
        </section>

        <section v-show="keys_data.is_delete_btn_clicked">
          <DeleteKeyForm
            :key_data="keys_data.key_being_actioned"
            @handleModalClose="handleModalClose"
          />
        </section>
      </template>
    </Modal>
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
import Modal from "../../shared/Modal";
import LoadingIndicator from "../../shared/LoadingIndicator";
import AppLink from "../../shared/AppLink";
import DeleteKeyForm from "./DeleteKeyForm";
import FetchKeyAuth from "./FetchKeyAuth";
import { debounce } from "lodash";
import {
  returnFormattedDate,
  returnCoWorkerFullName,
  scrollToTopOrBottomOfPage,
} from "../../helper/util";
const search_word = ref("");
const option_select_arr = ["All", "Free", "Inuse", "Lost"];

const props = defineProps({
  errors: Object,
  view_keys_prop_obj: {
    type: Object,
    default: {},
  },
  key_storage_res: {
    type: Object,
    default: {},
  },
});

const keys_data = reactive({
  view_keys_res: props.view_keys_prop_obj?.data,
  data_length: props.view_keys_prop_obj?.data.length,
  total_records: props.view_keys_prop_obj?.total,
  is_sorting: false,
  option_selected: option_select_arr[0],
  storage_name: "Select...",
  storage_id: 0,
  custom_err: props.errors?.fail == undefined ? "" : props.errors?.fail,
  is_searching: false,
  is_paginating: false,
  current_records_on_page: props.view_keys_prop_obj?.data.length,
  //View_key_auth and delete data
  show_modal: false,
  key_being_actioned: {},
  is_view_key_auth_btn_clicked: false,
  is_delete_btn_clicked: false,
  actioned_title: "",
});

const handleModalOpen = (action, key) => {
  keys_data.key_being_actioned = key;
  keys_data.show_modal = true;
  if (action == "view_auth") {
    keys_data.actioned_title = `View authorization for ${key.name}`;
    keys_data.is_view_key_auth_btn_clicked = true;
  } else if (action == "delete") {
    keys_data.actioned_title = `Delete key ${key.name}`;
    keys_data.is_delete_btn_clicked = true;
  }
};

const handleModalClose = () => {
  keys_data.actioned_title = "";
  keys_data.key_being_actioned = {};
  keys_data.show_modal = false;
  keys_data.is_view_key_auth_btn_clicked = false;
  keys_data.is_delete_btn_clicked = false;
};

const assignDataFromAxiosApiCall = (isPagnateResult) => {
  keys_data.data_length = props.view_keys_prop_obj?.data.length;
  keys_data.total_records = props.view_keys_prop_obj?.total;

  //if paginate result, add else replace.
  if (isPagnateResult) {
    keys_data.view_keys_res = [
      ...keys_data.view_keys_res,
      ...props.view_keys_prop_obj?.data,
    ];
    keys_data.current_records_on_page =
      keys_data.current_records_on_page + props.view_keys_prop_obj?.data.length;
  } else {
    keys_data.view_keys_res = props.view_keys_prop_obj?.data;
    keys_data.current_records_on_page = props.view_keys_prop_obj?.data.length;
  }
};

const returnTotalRecordsMsg = () => {
  let record_word = "record";

  if (keys_data.total_records > 1) {
    record_word = "records";
  }
  return (
    keys_data.current_records_on_page +
    " of " +
    keys_data.total_records +
    " total " +
    record_word
  );
};

const returnDataToBePost = () => {
  return {
    option_selected: keys_data.option_selected,
    searched_word: search_word.value,
    storage_id: keys_data.storage_id,
  };
};

const getData = async () => {
  router.post("/view-keys", returnDataToBePost(), {
    onFinish: () => {
      if (keys_data.is_searching) {
        keys_data.is_searching = false;
      }
      if (keys_data.is_sorting) {
        keys_data.is_sorting = false;
      }
    },
    onSuccess: () => {
      assignDataFromAxiosApiCall(false);
    },
  });
};

const handleSearchForm = () => {
  keys_data.is_searching = true;
  keys_data.current_records_on_page = 0;
  keys_data.option_selected = option_select_arr[0];
  getData();
};

const updateSelectedKeyStorage = (selected_storage) => {
  keys_data.is_sorting = true;
  keys_data.storage_id = selected_storage.id;
  keys_data.option_selected = "Storage";
  keys_data.current_records_on_page = 0;
  getData();
};

const handleSortSelectOption = async (selected_sort_option) => {
  keys_data.is_sorting = true;
  keys_data.option_selected = selected_sort_option;
  keys_data.current_records_on_page = 0;

  if (selected_sort_option == option_select_arr[0]) {
    keys_data.storage_id = 0;
  }

  getData();
};

const handleLoadMoreResult = async () => {
  if (!keys_data.is_searching) {
    if (props.view_keys_prop_obj?.next_page_url === null) {
      return;
    }

    router.post(props.view_keys_prop_obj?.next_page_url, returnDataToBePost(), {
      preserveState: true,
      preserveScroll: true,
      only: ["view_keys_prop_obj"],
      onStart: () => {
        keys_data.is_paginating = true;
      },
      onFinish: () => {
        keys_data.is_paginating = false;
      },
      onSuccess: () => {
        window.history.replaceState({}, "", props.view_keys_prop_obj?.path);
        scrollToTopOrBottomOfPage("bottom");
        assignDataFromAxiosApiCall(true);
      },
      onError: (e) => {
        console.log(e);
      },
    });
  } // end if !keys_data.is_searching
};

//Watch the search input value for changes.
watch(
  search_word,
  debounce(() => {
    handleSearchForm();
  }, 500)
);
</script>
