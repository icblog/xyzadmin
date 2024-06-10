<template>
  <div class="row">
    <div class="col-12">
      <div class="text-right pb-2">
        <AppButton :btnFunc="closeModal" btnStyle="primary">X</AppButton>
      </div>
      <div class="text-center bolded">
        <label class="mt-0 mb-1 text-color-black"
          >Key:
          <span class="text-danger bolded">{{ `${key_log_obj?.key_name}` }}</span>
        </label>
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
        <!-- Verify section -->
        <section
          v-show="!key_log_data.next_step && !key_log_data.is_different_coworker_name"
        >
          <p class="text-center">
            <span class="bolded">{{ key_log_obj?.coworker_name_out }}</span> bringing back
            key
            <span class="bolded">{{ key_log_obj?.key_name }} ?</span>
          </p>

          <div class="text-center">
            <AppButton :btnFunc="() => handleQuestionBtnClick('No_Q1')" btnStyle="warn"
              >No</AppButton
            >
            <AppButton
              :btnFunc="() => handleQuestionBtnClick('Yes_Q1')"
              customClass="ml-5"
              btnStyle="primary2"
              >Yes
            </AppButton>
          </div>
        </section>

        <section v-show="key_log_data.next_step">
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

          <div class="text-center">
            <AppButton :btnFunc="closeModal" btnStyle="warn">Cancel</AppButton>
            <AppButton :btnFunc="handleKeyLogForm" customClass="ml-5" btnStyle="primary2"
              >Log it
            </AppButton>
          </div>
        </section>
        <!-- Find co-worker section -->
        <section v-show="key_log_data.is_different_coworker_name" class="pt-3">
          <div
            v-show="!key_log_data.next_step && key_log_data.different_coworker_name != ''"
          >
            <p class="mt-0 mb-0">
              <span class="bolded">Coworker name:</span>
              <span class="text-color-black ml-1">
                {{
                  key_log_data.different_coworker_name != ""
                    ? key_log_data.different_coworker_name
                    : ""
                }}
              </span>
              <span>
                <AppButton
                  :btnFunc="handleChangeBtnClick"
                  customClass="change-selected-btn ml-1"
                >
                  Change
                </AppButton></span
              >
            </p>

            <p class="mt-1">
              <span class="bolded">Coworker department:</span>
              <span class="text-color-black ml-1">
                {{
                  key_log_data.different_coworker_department != ""
                    ? key_log_data.different_coworker_department
                    : ""
                }}
              </span>
            </p>
            <div class="text-center">
              <AppButton :btnFunc="closeModal" btnStyle="warn">Cancel</AppButton>
              <AppButton
                :btnFunc="() => handleQuestionBtnClick('Yes_Q1')"
                customClass="ml-5"
                btnStyle="primary2"
                >Continue
              </AppButton>
            </div>
          </div>
          <div v-show="key_log_data.different_coworker_name == ''">
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

const props = defineProps({
  key_log_obj: {
    type: Object,
    default: {},
  },
});
const key_log_data = reactive({
  next_step: false,
  is_form_processing: false,
  custom_err: "",
  custom_success: "",
  is_different_coworker_name: false,
  different_coworker_name: "",
  different_coworker_department: "",

  form_data: {
    key_name: "",
    key_log_id: 0,
    coworker_name: "",
    coworker_department: "",
    comment: "",
    action: "keyin",
  },
});
const handleQuestionBtnClick = (q_answer) => {
  if (q_answer == "Yes_Q1") {
    key_log_data.next_step = true;
  } else if (q_answer == "No_Q1") {
    key_log_data.is_different_coworker_name = true;
  }
};

const handleKeyLogForm = () => {
  key_log_data.is_form_processing = true;

  key_log_data.form_data.key_log_id = props.key_log_obj?.id;
  key_log_data.form_data.key_name = props.key_log_obj?.key_name;

  if (key_log_data.different_coworker_name != "") {
    key_log_data.form_data.coworker_name = key_log_data.different_coworker_name;
    key_log_data.form_data.coworker_department =
      key_log_data.different_coworker_department;
  } else {
    key_log_data.form_data.coworker_name = props.key_log_obj?.coworker_name_out;
    key_log_data.form_data.coworker_department =
      props.key_log_obj?.coworker_department_out;
  }

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

const handleChangeBtnClick = () => {
  key_log_data.different_coworker_name = "";
};

const updateSelectedCoworker = (selected_coworker) => {
  key_log_data.different_coworker_name = returnCoWorkerFullName(
    selected_coworker.fname,
    selected_coworker.lname
  );
  key_log_data.different_coworker_department = selected_coworker.department_name;
};

const closeModal = () => {
  key_log_data.is_different_coworker_name = false;
  key_log_data.different_coworker_name = "";
  key_log_data.different_coworker_department = "";
  key_log_data.next_step = false;
  key_log_data.custom_err = "";

  emit("handleModalClose");
};
</script>
