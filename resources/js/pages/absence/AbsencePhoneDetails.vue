<template>
  <!-- <div class="text-right pb-2">
    <AppButton :btnFunc="closeModal" btnStyle="primary">X</AppButton>
  </div>
  <hr /> -->
  <div v-if="view_phone_res_data.data_length > 0">
    <LocalSearch
      :oldResultObj="view_phone_res_data.default_phone_res"
      inputPlaceHolderValue="Search department phone..."
      @updateResultObj="updateLocalViewPhoneResultSet"
    />
    <section class="absence-phone-result">
      <div
        class="row"
        v-for="(department, depart_index) in view_phone_res_data.view_phone_res"
        :key="depart_index"
      >
        <div class="col-md-12 mb-3">
          <Accordion
            :key="depart_index"
            :activeIndex="view_phone_res_data.current_active_accordion_index"
            :itemIndex="depart_index"
            @update:itemIndex="
              view_phone_res_data.current_active_accordion_index = $event
            "
          >
            <template v-slot:accordion-trigger>
              <span>
                {{ department.name }}
              </span>
            </template>
            <template v-slot:accordion-content>
              <div class="absence-result-wrapper">
                <div class="row">
                  <div
                    class="col-md-12 pl-4 pt-3 pb-1 pl-3"
                    v-html="returnDepartmentPhonesJsx(department)"
                  ></div>
                  <div class="col-md-12 pl-4 pt-1 pb-1 pl-3">
                    <span class="pr-1 bolded">Email:</span
                    ><span>{{
                      department.email == null ? "---" : department.email
                    }}</span>
                  </div>
                  <!-- end row -->
                </div>
              </div>
            </template>
          </Accordion>
        </div>
      </div>
    </section>
  </div>
  <div v-else>
    <p class="small">Sorry no phone result found</p>
  </div>
</template>
<script setup>
import { reactive } from "vue";
import LocalSearch from "../../shared/LocalSearch";
import AppButton from "../../shared/AppButton";
import Accordion from "../../shared/Accordion";

const emit = defineEmits(["handleModalClose"]);
const props = defineProps({
  errors: {
    type: Object,
    default: {},
  },

  view_phone_res: {
    type: Array,
    default: [],
  },
});

const view_phone_res_data = reactive({
  default_phone_res: props?.view_phone_res,
  view_phone_res: props?.view_phone_res,
  data_length: props?.view_phone_res?.length,
  custom_err: props.errors?.fail == undefined ? "" : props.errors?.fail,
  current_active_accordion_index: null,
});

// const closeModal = () => {
//   emit("handleModalClose");
// };

const updateLocalViewPhoneResultSet = (res_obj) => {
  view_phone_res_data.view_phone_res = res_obj.arrObj;
};

const returnDepartmentPhonesJsx = (department) => {
  if (department.depart_phones != null) {
    let depart_arr = department.depart_phones.split(","),
      result = "";

    depart_arr.map((phone, index) => {
      let tem_phone = phone.split(":");
      result =
        result +
        `<span class="pr-3" key="${index}"><span class="bolded">${tem_phone[0]}:</span> <span>${tem_phone[1]}</span></span>`;
    });
    return result;
  } //end department.depart_phones != null
};
</script>
