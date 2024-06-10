<template>
  <div class="row">
    <div class="col">
      <div class="pb-2">
        <AppLink
          className="btn-primary btn no-border-radius mr-2"
          :linkUrl="'/edit-key/' + Number(key_data?.id)"
        >
          Amend list
          <span>
            <i class="fas fa-edit"></i>
          </span>
        </AppLink>
      </div>
    </div>
    <div class="col">
      <div class="text-right pb-2">
        <AppButton :btnFunc="closeModal" btnStyle="primary">X</AppButton>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h6 class="text-center">Key {{ key_data?.name }}</h6>
      <p class="small text-center">{{ key_data?.description }}</p>
    </div>
  </div>

  <div class="form-wrapper">
    <section v-if="fetch_key_auth_data.is_processing">
      <LoadingIndicator />
    </section>

    <section v-else>
      <HandleMsg
        v-if="fetch_key_auth_data.custom_err != ''"
        infotype="error"
        :msg="fetch_key_auth_data.custom_err"
        customClass="form-responds-msg"
      />
      <div v-else class="row">
        <div class="col-md-12 mb-5">
          <div
            v-if="fetch_key_auth_data.coworker_auth_data.length > 0"
            class="form-group"
          >
            <OptionElementInput
              :defaultOptionSelected="`View authorized co-workers to use key ${key_data?.name}`"
              :allowSelection="false"
              :resultObj="fetch_key_auth_data.coworker_auth_data"
              :disabledInput="true"
              @updateSelectedOptionInput="null"
            />
          </div>
          <div v-else>
            <h6>View authorized co-workers to use key {{ key_data?.name }}</h6>
            <p class="small">
              There are currently no authorized co-workers for key
              {{ key_data?.name }}.
            </p>
          </div>
        </div>
        <hr />
        <div class="col-md-12">
          <div v-if="fetch_key_auth_data.depart_auth_data.length > 0" class="form-group">
            <OptionElementInput
              :defaultOptionSelected="`View authorized departments to use key ${key_data?.name}`"
              :allowSelection="false"
              :resultObj="fetch_key_auth_data.depart_auth_data"
              :disabledInput="true"
              @updateSelectedOptionInput="null"
            />
          </div>
          <div v-else>
            <h6>View authorized departments to use key {{ key_data?.name }}</h6>
            <p class="small">
              There are currently no authorized departments for key
              {{ key_data?.name }}.
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { reactive, watch } from "vue";
import LoadingIndicator from "../../shared/LoadingIndicator";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import AppLink from "../../shared/AppLink";
import { returnSystemErrorMsg } from "../../helper/util";
import OptionElementInput from "../../shared/OptionElementInput";
import axios from "../../api/axios";

const emit = defineEmits(["handleModalClose"]);

const props = defineProps({
  key_data: {
    type: Object,
    default: {},
  },

  is_go_ahead: {
    type: Boolean,
    default: false,
  },
});
const fetch_key_auth_data = reactive({
  is_processing: false,
  custom_err: "",
  custom_success: "",
  depart_auth_data: {},
  coworker_auth_data: {},
});

const closeModal = () => {
  emit("handleModalClose");
};

const fetchKeyAuth = async () => {
  try {
    const res = await axios.post("/keys/fetch-key-auth", {
      key_id: props.key_data?.id,
    });
    if (res?.data?.error != "") {
      fetch_key_auth_data.custom_err = res?.data?.error;
    } else {
      console.log(res?.data?.auth_data);
      fetch_key_auth_data.depart_auth_data = res?.data?.auth_data.depart_key_auth;
      fetch_key_auth_data.coworker_auth_data = res?.data?.auth_data.coworker_key_auth;
    }
  } catch (err) {
    fetch_key_auth_data.custom_err = returnSystemErrorMsg();
  } finally {
    fetch_key_auth_data.is_processing = false;
  }
};

watch(
  () => props.is_go_ahead,
  (new_value, old_value) => {
    if (new_value != undefined && new_value) {
      fetch_key_auth_data.depart_auth_data = {};
      fetch_key_auth_data.coworker_auth_data = {};
      fetch_key_auth_data.is_processing = true;
      setTimeout(() => {
        fetchKeyAuth();
      }, 400);
    }
  }
);
</script>
