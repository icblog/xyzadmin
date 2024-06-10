<template>
  <div class="row">
    <div class="col-12">
      <div class="text-right pb-2">
        <AppButton :btnFunc="closeModal" btnStyle="primary">X</AppButton>
      </div>
      <div class="text-center bolded">
        <label class="mt-0 mb-1 text-color-black">Log a key out </label>
      </div>
    </div>
  </div>

  <div class="form-wrapper">
    <section v-show="key_log_data.is_form_processing">
      <LoadingIndicator />
    </section>

    <section v-show="!key_log_data.is_form_processing">
      <HandleMsg
        v-if="key_log_data.custom_err != ''"
        infotype="error"
        :msg="key_log_data.custom_err"
        customClass="form-responds-msg"
      />
      <HandleMsg
        v-else-if="key_log_data.custom_success != ''"
        infotype="success"
        :msg="key_log_data.custom_success"
        customClass="form-responds-msg"
      />
      <section v-else>
        <!-- Find key section -->
        <section>
          <p class="mt-0 mb-0">
            <span class="bolded"> Key name:</span>
            <span class="text-color-black ml-1">
              {{
                key_log_data.form_data.key_name != ""
                  ? key_log_data.form_data.key_name
                  : ""
              }}
            </span>
            <span v-show="key_log_data.form_data.key_name != ''">
              <AppButton
                :btnFunc="() => handleChangeBtnClick('change_key')"
                customClass="change-selected-btn ml-1"
              >
                Change
              </AppButton></span
            >
          </p>
          <p v-show="key_log_data.form_data.key_name != ''" class="mt-2 mb-0">
            <span class="bolded">Key description:</span>
            <span class="text-color-black ml-1">
              {{ key_log_data.key_description != "" ? key_log_data.key_description : "" }}
            </span>
          </p>

          <div v-show="key_log_data.form_data.key_name == ''">
            <CoWorkerSearch
              :makeResultAlink="false"
              end_point="/keys/find-key"
              dataStringValue="name"
              :isGeneralData="true"
              :focusOnSearchInput="true"
              placeholderText="Type the key name..."
              @updateSelected="updateSelectedKey"
            />
          </div>
        </section>
        <!-- Find co-worker section -->
        <section class="pt-3" v-show="key_log_data.next_step">
          <p class="mt-0 mb-0">
            <span class="bolded">Coworker name:</span>
            <span class="text-color-black ml-1">
              {{
                key_log_data.form_data.coworker_name != ""
                  ? key_log_data.form_data.coworker_name
                  : ""
              }}
            </span>
            <span v-show="key_log_data.form_data.coworker_name != ''">
              <AppButton
                :btnFunc="() => handleChangeBtnClick('change_coworker')"
                customClass="change-selected-btn ml-1"
              >
                Change
              </AppButton></span
            >
          </p>

          <p v-show="key_log_data.form_data.coworker_name != ''" class="mt-2 mb-0">
            <span class="bolded">Coworker department:</span>
            <span class="text-color-black ml-1">
              {{
                key_log_data.form_data.coworker_department != ""
                  ? key_log_data.form_data.coworker_department
                  : ""
              }}
            </span>
          </p>

          <div v-show="key_log_data.form_data.coworker_name == ''">
            <CoWorkerSearch
              end_point="/keys/find-coworker"
              :makeResultAlink="false"
              :focusOnSearchInput="true"
              resultFoundTextSingular="person"
              resultFoundTextplural="people"
              noResultText="Sorry no one found, try again thank you."
              @updateSelected="updateSelectedCoworker"
            />
          </div>

          <p class="text-center pt-2" v-show="key_log_data.checking_key_auth">
            <LoadingIndicator loaderSize="small" />
          </p>

          <div
            v-show="
              key_log_data.checking_key_auth_complete &&
              key_log_data.form_data.key_name != '' &&
              key_log_data.form_data.coworker_name != ''
            "
            class="pt-2"
          >
            <div class="form-group">
              <label class="form-label"
                >Comment:
                <span class="optional">(Optional)</span>
              </label>

              <textarea
                v-model="key_log_data.form_data.comment"
                class="form-control"
                rows="1"
                cols="10"
              ></textarea>
            </div>
            <p
              class="text-center text-danger pt-2"
              v-show="key_log_data.checking_key_auth_err != ''"
            >
              <span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> </span>
              {{ key_log_data.checking_key_auth_err }}
            </p>
            <div class="text-center">
              <AppButton :btnFunc="closeModal" btnStyle="warn">Cancel</AppButton>
              <AppButton
                :btnFunc="handleKeyLogForm"
                customClass="ml-5"
                btnStyle="primary2"
                >Log it
                {{ key_log_data.checking_key_auth_err != "" ? "anyway" : "" }}</AppButton
              >
            </div>
          </div>
        </section>
        <!-- Feedback section -->
        <section class="pt-2">
          <HandleMsg
            v-if="key_log_data.feed_back != ''"
            infotype="error"
            :msg="key_log_data.feed_back"
            customClass="form-responds-msg"
          />
        </section>
      </section>
    </section>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import LoadingIndicator from "../../shared/LoadingIndicator";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import CoWorkerSearch from "../../shared/CoWorkerSearch";
import { returnSystemErrorMsg, returnCoWorkerFullName } from "../../helper/util";
import axios from "../../api/axios";

const emit = defineEmits(["handleModalClose"]);

const key_log_data = reactive({
  feed_back: "",
  key_status: "",
  key_description: "",
  next_step: false,
  checking_key_auth: false,
  checking_key_auth_complete: false,
  checking_key_auth_err: "",

  is_form_processing: false,
  custom_err: "",
  custom_success: "",
  form_data: {
    key_id: 0,
    key_name: "",
    coworker_name: "",
    coworker_department: "",
    comment: "",
    is_coworker_authorized: 1,
    action: "keyout",
  },
});

const handleKeyLogForm = () => {
  key_log_data.is_form_processing = true;
  setTimeout(async () => {
    try {
      const res = await axios.post("/keys/handle-log-key", key_log_data.form_data);
      if (res?.data?.error != "") {
        key_log_data.custom_err = res?.data?.error;
      } else {
        //success
        key_log_data.custom_success = `Thanks, key ${key_log_data.form_data.key_name} has been successfully logged`;
        setTimeout(() => {
          router.get("/keys/log");
        }, 1000);
      }
    } catch (err) {
      //   console.log(err);
      key_log_data.custom_err = returnSystemErrorMsg();
    } finally {
      key_log_data.is_form_processing = false;
    }
  }, 200);
};

const fetchKeyAuth = (key_id, coworker_id, coworker_department_id) => {
  key_log_data.checking_key_auth_complete = false;
  key_log_data.checking_key_auth = true;

  setTimeout(async () => {
    try {
      const res = await axios.post("/keys/fetch-key-auth", {
        key_id: key_id,
      });
      if (res?.data?.error != "") {
        key_log_data.checking_key_auth_err = res?.data?.error;
      } else {
        let is_coworker_auth = false;

        if (res?.data?.auth_data.coworker_key_auth.length > 0) {
          res?.data?.auth_data.coworker_key_auth.forEach((coworker) => {
            if (coworker.id == coworker_id) {
              is_coworker_auth = true;
            }
          });
        }

        if (res?.data?.auth_data.depart_key_auth.length > 0) {
          res?.data?.auth_data.depart_key_auth.forEach((department) => {
            if (department.id == coworker_department_id) {
              is_coworker_auth = true;
            }
          });
        }
        if (!is_coworker_auth) {
          key_log_data.form_data.is_coworker_authorized = 0;
          key_log_data.checking_key_auth_err = `${key_log_data.form_data.coworker_name} is not authorized to use key ${key_log_data.form_data.key_name}`;
        }
      }
    } catch (err) {
      key_log_data.checking_key_auth_err = returnSystemErrorMsg();
    } finally {
      key_log_data.checking_key_auth_complete = true;
      key_log_data.checking_key_auth = false;
    }
  }, 100);
};

const handleChangeBtnClick = (action) => {
  key_log_data.feed_back = "";
  key_log_data.checking_key_auth_err = "";
  key_log_data.key_status = "";
  key_log_data.next_step = false;

  if (action == "change_key") {
    key_log_data.form_data.key_name = "";
  }
  if (action == "change_coworker") {
    key_log_data.next_step = true;
    key_log_data.form_data.coworker_name = "";
  }
};

const updateSelectedKey = (selected_key) => {
  key_log_data.form_data.key_name = selected_key.name;
  key_log_data.form_data.key_status = selected_key.status;
  key_log_data.form_data.key_id = selected_key.id;
  key_log_data.key_description = selected_key.description;

  if (selected_key.status == 1) {
    key_log_data.feed_back = `Sorry key ${selected_key.name} is inuse, if this isn't the case, please log it back in before logging it out`;
    key_log_data.next_step = false;
  } else if (selected_key.status == 2) {
    key_log_data.feed_back = `Sorry key ${selected_key.name} was reported lost, if it's been found, please edit the key status before logging it out`;
    key_log_data.next_step = false;
  } else {
    key_log_data.next_step = true;
  }
};
const updateSelectedCoworker = (selected_coworker) => {
  key_log_data.form_data.coworker_name = returnCoWorkerFullName(
    selected_coworker.fname,
    selected_coworker.lname
  );
  key_log_data.form_data.coworker_department = selected_coworker.department_name;

  fetchKeyAuth(
    key_log_data.form_data.key_id,
    selected_coworker.id,
    selected_coworker.department_id
  );
};

const closeModal = () => {
  key_log_data.form_data.key_name = "";
  key_log_data.form_data.coworker_name = "";
  key_log_data.form_data.coworker_department = "";
  key_log_data.feed_back = "";
  key_log_data.key_status = "";
  key_log_data.next_step = false;
  key_log_data.checking_key_auth_err = "";
  key_log_data.custom_err = "";

  emit("handleModalClose");
};
</script>
