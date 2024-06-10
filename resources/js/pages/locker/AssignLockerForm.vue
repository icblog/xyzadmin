<template>
  <div class="row">
    <div class="col-6">
      <div
        v-show="
          assign_locker_data.coworker_name != '' &&
          assign_locker_data.custom_err == '' &&
          assign_locker_data.custom_success == ''
        "
        class="pb-2"
      >
        <AppButton :btnFunc="handleBackBtn" btnStyle="primary">Back</AppButton>
      </div>
    </div>

    <div class="col-6">
      <div class="text-right pb-2">
        <AppButton :btnFunc="closeModal" btnStyle="primary">X</AppButton>
      </div>
    </div>
  </div>

  <div class="form-wrapper">
    <section v-show="assign_locker_data.is_form_processing">
      <LoadingIndicator />
    </section>

    <section v-show="!assign_locker_data.is_form_processing">
      <HandleMsg
        v-if="assign_locker_data.custom_err != ''"
        infotype="error"
        :msg="assign_locker_data.custom_err"
        customClass="form-responds-msg"
      />
      <HandleMsg
        v-else-if="assign_locker_data.custom_success != ''"
        infotype="success"
        :msg="assign_locker_data.custom_success"
        customClass="form-responds-msg"
      />
      <form class="mb-4" v-else @submit.prevent="handleAssignForm">
        <div class="text-center">
          <label class="form-label mt-0 mb-0">Assigning locker {{ locker?.name }}</label>
          <hr class="mt-1 mb-1" />
        </div>
        <div v-if="assign_locker_data.coworker_name == ''">
          <p class="small">
            Step <span class="bolded">1 of 2</span><br />
            Find the co-worker name and click on it.
          </p>
          <label class="form-label">Co-worker name* </label>
          <CoWorkerSearch
            :makeResultAlink="false"
            resultFoundTextSingular="person"
            resultFoundTextplural="people"
            noResultText="Sorry no one found, try again thank you."
            @updateSelected="updateSelectedCoworker"
          />
        </div>
        <div v-else>
          <p class="small">Step <span class="bolded">2 of 2</span></p>
          <p class="small">
            {{ assign_locker_data.coworker_name }} current locker is
            <span class="bolded">{{
              assign_locker_data.previous_coworker_locker_name != null
                ? assign_locker_data.previous_coworker_locker_name
                : "---"
            }}</span>
          </p>
          <p>
            Assign locker <span class="bolded">{{ locker?.name }}</span> to
            <span class="bolded"> {{ assign_locker_data.coworker_name }}</span
            >?
          </p>
          <div>
            <AppButton customClass="mr-5" btnType="submit" btnStyle="primary2"
              >Yes</AppButton
            >
            <AppButton :btnFunc="closeModal" btnStyle="warn">No</AppButton>
          </div>
        </div>
      </form>
    </section>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import CoWorkerSearch from "../../shared/CoWorkerSearch";
import LoadingIndicator from "../../shared/LoadingIndicator";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import { returnCoWorkerFullName, returnSystemErrorMsg } from "../../helper/util";
import axios from "../../api/axios";

const emit = defineEmits(["handleModalClose"]);

const props = defineProps({
  locker: {
    type: Object,
    default: {},
  },
});
const assign_locker_data = reactive({
  coworker_name: "",
  coworker_id: 0,
  previous_coworker_locker: 0,
  previous_coworker_locker_name: "",
  is_form_processing: false,
  custom_err: "",
  custom_success: "",
});
const updateSelectedCoworker = (selected_coworker) => {
  //console.log(selected_coworker.locker);
  assign_locker_data.coworker_id = selected_coworker.id;
  assign_locker_data.previous_coworker_locker = selected_coworker.locker;
  assign_locker_data.previous_coworker_locker_name = selected_coworker.locker_name;
  assign_locker_data.coworker_name = returnCoWorkerFullName(
    selected_coworker.fname,
    selected_coworker.lname
  );
};

const closeModal = () => {
  assign_locker_data.coworker_id = "";
  assign_locker_data.coworker_name = "";
  emit("handleModalClose");
};
const handleBackBtn = () => {
  assign_locker_data.coworker_id = "";
  assign_locker_data.coworker_name = "";
};

const handleAssignForm = async () => {
  try {
    assign_locker_data.is_form_processing = true;

    const res = await axios.post("/lockers/handle-assign-locker", {
      locker_id: props.locker?.id,
      coworker_id: assign_locker_data.coworker_id,
      previous_coworker_locker: assign_locker_data.previous_coworker_locker,
      action: "assign",
    });
    if (res?.data?.error != "") {
      assign_locker_data.custom_err = res?.data?.error;
    } else {
      //success
      assign_locker_data.custom_success = `Thanks, locker ${props.locker?.name} has been successfully assigned to ${assign_locker_data.coworker_name}`;
      setTimeout(() => {
        router.get("/lockers");
      }, 4000);
    }
  } catch (err) {
    //console.log(err);
    assign_locker_data.custom_err = returnSystemErrorMsg();
  } finally {
    assign_locker_data.is_form_processing = false;
  }
};
</script>
