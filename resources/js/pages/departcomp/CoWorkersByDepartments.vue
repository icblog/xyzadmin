<template>
  <div class="row">
    <div class="col-md-12">
      <h6>Total co-workers by departments</h6>

      <div class="absence-total-department-wrapper total-department-wrapper">
        <div class="total-department-btn-wrapper">
          <span
            v-if="depart_coworker_count_result.length > 0"
            v-for="(department, depart_index) in depart_coworker_count_result"
            :key="depart_index"
          >
           <span v-show="department.name !='All department'"> 
            <span v-if="department.department_user_total > 0" class="mr-2">
              <AppButton
                :noBtnStyle="true"
                btnType="button"
                :customClassObj="{
                  'total-depart-btn': true,
                  'department-absence-total-morethan-zerobtn':
                    department.department_user_total > 0,
                  'total-depart-active-btn':
                    depart_co_worker_data.depart_id_clicked == department.id,
                }"
                :btnFunc="() => handleDepartCowokerClick(department.id, department.name)"
              >
                {{ department.name + " (" + department.department_user_total + ")" }}
              </AppButton>
            </span>
            <span v-else class="mr-3">
              {{ department.name + " (" + department.department_user_total + ")" }}
            </span>
          </span> 
          </span>
        </div>
      </div>
    </div>
    <!-- end row -->
  </div>
  <div
    v-if="
      depart_co_worker_data.co_worker_arr.length > 0 &&
      depart_co_worker_data.show_coworker_department_detail_div
    "
    class="depart-coworker-wrapper"
  >
    <section v-if="depart_co_worker_data.is_fetching">
      <div class="row pt-2">
        <div class="col-md-6 mx-auto pt-2">
          <LoadingIndicator />
        </div>
      </div>
    </section>
    <section v-else>
      <div class="row">
        <div class="col-md-12 pt-0 pb-0">
          <div class="text-right pt-2 pr-2">
            <AppButton
              btnType="button"
              :btnFunc="closeCoWorkerDetailDiv"
              customClass="primary-btn"
              >X</AppButton
            >
          </div>
          <div class="text-center">
            <p class="pt-0 pb-0 mt-0 mb-2 small bolded">
              {{ depart_co_worker_data.clicked_depart_name }} co-workers
            </p>
            <hr class="mt-0 mb-0 ml-2 mr-2" />
          </div>
        </div>
        <!-- end row -->
      </div>
      <div class="row">
        <div class="col"><span class="ml-2">Name:</span></div>
        <div class="col"><span>Role:</span></div>
        <div class="col"><span>Joined:</span></div>
        <!-- end row -->
      </div>
      <div
        v-for="(co_worker, co_worker_index) in depart_co_worker_data.co_worker_arr"
        :key="co_worker_index"
      >
        <div
          v-show="depart_co_worker_data.depart_id_clicked === co_worker.department"
          class="p-2"
        >
          <div class="row pt-0 pb-0">
            <div class="col pt-0 pb-0">
              <span>{{ co_worker.fname + " " + co_worker.lname }}</span>
            </div>
            <div class="col pt-0 pb-0">
              <span>{{ co_worker.role === 0 ? " Co-worker" : " Admin" }}</span>
            </div>
            <div class="col pt-0 pb-0">
              <span>{{ returnFormattedDate(co_worker.created_at) }}</span>
            </div>
          </div>

          <!-- end row -->
        </div>
      </div>
    </section>
  </div>
  <div class="row">
    <div class="col-md-12">
      <hr />
    </div>
    <!-- end row -->
  </div>
</template>
<script setup>
import { reactive } from "vue";
import AppButton from "../../shared/AppButton";
import LoadingIndicator from "../../shared/LoadingIndicator";
import axios from "../../api/axios";
import { returnSystemErrorMsg, returnFormattedDate } from "../../helper/util";
const props = defineProps({
  depart_coworker_count_result: {
    type: Object,
    default: {},
  },
});

const depart_co_worker_data = reactive({
  depart_id_clicked: "",
  co_worker_arr: [],
  already_fetch_depart_names: "",
  show_coworker_department_detail_div: false,
  is_fetching: false,
  depart_co_worker_err: "",
  clicked_depart_name: "",
});

const closeCoWorkerDetailDiv = () => {
  depart_co_worker_data.depart_id_clicked = "";
  depart_co_worker_data.show_coworker_department_detail_div = false;
};

const handleDepartCowokerClick = (depart_id, depart_name) => {
  depart_co_worker_data.depart_id_clicked = depart_id;
  depart_co_worker_data.show_coworker_department_detail_div = true;
  depart_co_worker_data.is_fetching = true;

  let abort = false;
  if (depart_co_worker_data.already_fetch_depart_names != "") {
    if (
      depart_co_worker_data.already_fetch_depart_names.indexOf(depart_name + ",") > -1
    ) {
      abort = true;
      depart_co_worker_data.is_fetching = false;
    }
  }

  if (!abort) {
    setTimeout(async () => {
      depart_co_worker_data.is_fetching = false;
      //console.log(depart_co_worker_data.already_fetch_depart_names);
      try {
        const res = await axios.post("/depart-comp/depart-coworkers", {
          depart_id: depart_id,
        });
        //res.data.outcome can be boolean or error message
        if (res?.data?.error == "") {
          //success
          //Append the department name that was clciked
          depart_co_worker_data.already_fetch_depart_names += depart_name + ",";
          depart_co_worker_data.clicked_depart_name = depart_name;
          //push the fetch data
          depart_co_worker_data.co_worker_arr = [
            ...depart_co_worker_data.co_worker_arr,
            ...res?.data?.depart_coworkers_res,
          ];
        } else {
          //Set error meg
          depart_co_worker_data.depart_co_worker_err = res?.data?.error;
          //console.log("PHONE ERROR =>", res.data.outcome);
        }
      } catch (err) {
        depart_co_worker_data.depart_co_worker_err = returnSystemErrorMsg();
        //console.log("ERR =>", err);
      } finally {
        depart_co_worker_data.is_fetching = false;
      }
    }, 700);
  } // end if abort is false
};
</script>
