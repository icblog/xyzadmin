<template>
  <div v-if="key_log_result_details.length > 0">
    <hr />
    <div
      v-for="(key_log_detail, key_log_index) in key_log_result_details"
      :key="key_log_index"
      :class="{
        'row box-shadow mb-4': true,
        'key-out-highliter': key_log_detail.in_at == null ? true : false,
      }"
    >
      <div class="col-md-4 pt-0 mt-0 pb-0 mb-0">
        <ul class="result-detail-ul cf">
          <li>
            Key name: <span>{{ key_log_detail.key_name }}</span>
          </li>

          <li>
            Co-worker name out: <span>{{ key_log_detail.coworker_name_out }}</span>
          </li>

          <li>
            Co-worker department out:
            <span>{{ key_log_detail.coworker_department_out }}</span>
          </li>
          <li>
            Date out: <span>{{ returnFormattedDate(key_log_detail.out_at) }}</span>
          </li>
          <li>
            Time out:
            <span>{{ returnFormattedDate(key_log_detail.out_at, false, true) }}</span>
          </li>
          <li>
            Gave it out by:
            <span>{{ key_log_detail.risk_coworker_name_out }}</span>
          </li>
        </ul>
        <!-- end col-md-4-->
      </div>
      <div class="col-md-8 pb-0 mb-0">
        <div class="row">
          <div class="col-8">
            <ul class="result-detail-ul cf">
              <li>
                Coworker authorized:
                <span>{{
                  key_log_detail.is_coworker_authorized == 0 ? "No" : "Yes"
                }}</span>
              </li>
              <li>
                Co-worker name in:
                <span>{{
                  key_log_detail.coworker_name_in == null
                    ? "---"
                    : key_log_detail.coworker_name_in
                }}</span>
              </li>

              <li>
                Co-worker department in:
                <span>{{
                  key_log_detail.coworker_department_in == null
                    ? "---"
                    : key_log_detail.coworker_department_in
                }}</span>
              </li>
              <li>
                Date in:
                <span>{{
                  key_log_detail.in_at === null
                    ? "---"
                    : returnFormattedDate(key_log_detail.in_at)
                }}</span>
              </li>
              <li>
                Time in:
                <span>{{
                  key_log_detail.in_at === null
                    ? "---"
                    : returnFormattedDate(key_log_detail.in_at, false, true)
                }}</span>
              </li>

              <li>
                Received it in by:
                <span>{{
                  key_log_detail.risk_coworker_name_in === null
                    ? "---"
                    : key_log_detail.risk_coworker_name_in
                }}</span>
              </li>
              <li>
                comment:
                <span>{{
                  key_log_detail.comment == null ? "---" : key_log_detail.comment
                }}</span>
              </li>
            </ul>
          </div>
          <div class="col-4">
            <div
              v-show="key_log_detail.in_at == null"
              class="mt-0 mb-0 pt-0 pb-0 text-right"
            >
              <AppButton
                customClass="mr-3 pt-1 pb-1 mt-3"
                btnStyle="primary2"
                :btnFunc="() => openModal(key_log_detail)"
                >Key in <i class="fas fa-arrow-down"></i
              ></AppButton>
            </div>
          </div>
        </div>

        <!-- end col-md-8-->
      </div>

      <!-- end row -->
    </div>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import AppButton from "../../shared/AppButton";
import { returnFormattedDate } from "../../helper/util";

const emit = defineEmits(["handleKeyInModal"]);

const props = defineProps({
  key_log_result_details: {},
});

const key_log_reactive_data = reactive({
  current_active_accordion_index: null,
});

const openModal = (key_log_obj) => {
  emit("handleKeyInModal", key_log_obj);
};
</script>
