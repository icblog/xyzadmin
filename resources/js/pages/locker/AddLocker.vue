<template>
  <Layout pageTitle="add-locker" pageIntro="Add locker">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="5" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="form-wrapper">
              <section v-if="add_locker_data.is_form_processing">
                <LoadingIndicator />
              </section>

              <section v-else>
                <form @submit.prevent="handleAddLockerForm">
                  <HandleMsg
                    v-if="add_locker_data.custom_err != ''"
                    infotype="error"
                    :msg="add_locker_data.custom_err"
                    customClass="form-responds-msg"
                  />
                  <div v-else-if="add_locker_data.custom_success != ''">
                    <HandleMsg
                      infotype="success"
                      :msg="add_locker_data.custom_success"
                      customClass="form-responds-msg"
                    />
                    <AfterSuccessBtn
                      add_link_name="/lockers/add"
                      redirect_link_name="/lockers"
                      click_action_add="add_lockers"
                      click_action_redirect="view_lockers"
                      add_btn_name="Add another locker"
                      redirect_btn_name="View lockers"
                      @updateSuccessCancelTimer="updateSuccessCancelTimer"
                    />
                  </div>
                  <div v-else>
                    <p class="small pb-1">
                      Provide locker name or number, comment is optional.
                      <hr class="m-0"/>
                    </p>

                    <div class="form-group">
                          <label class="form-label" for="name"
                            >Locker name/number*</label
                          >
                          <div
                            v-show="add_locker_data.form_error.name_err != ''"
                            class="small text-danger p-0 m-0"
                          >
                            {{ add_locker_data.form_error.name_err }}
                          </div>
                          <input
                            ref="firstInput"
                            type="text"
                            id="name"
                            v-model="add_locker_data.form_data.name"
                            class="form-control"
                            maxlength="255"
                            @focus="() => removeFormErr('name')"
                          />
                        </div>

                    <div class="form-group">
                            <label class="form-label"
                              >Comment:
                              <span
                                class="optional"
                                >(Optional)</span
                              >
                            </label>
                            <div v-show="add_locker_data.form_error.comment_err !=''" class="small text-danger p-0 m-0">
                              {{ add_locker_data.form_error.comment_err }}
                            </div>
                             <textarea
                                v-model="add_locker_data.form_data.comment"
                                class="form-control"
                                rows="1"
                                cols="10"
                                @focus="()=>removeFormErr('comment')"
                              ></textarea>
                            
                          </div>
                          <p class="small pt-1">
                      Please note, all fields marked with a * are mandatory
                    </p>
                    <div class="pt-3 row">
                      <div class="col-md-6 mx-auto">
                        <AppButton btnType="submit" btnStyle="primary" :fullBtn="true">Submit</AppButton>
                      </div>
                    </div>
                  </div>
                </form>
              </section>
              <!-- end form wrapper -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";
import HandleMsg from "../../shared/HandleMsg";
import AfterSuccessBtn from "../../shared/AfterSuccessBtn";
import AppButton from "../../shared/AppButton";
import LoadingIndicator from "../../shared/LoadingIndicator";
import {
  focusOnFirstInput,
  returnSystemErrorMsg,

} from "../../helper/util";
import axios from "../../api/axios";

const firstInput = ref(null);

const props = defineProps({
  errors: Object,
});

const add_locker_data = reactive({
  form_data: {
    name: "",
    comment: "",
  },
  form_error: {
    name_err: "",
    comment_err: "",
  },
  custom_err: "",
  custom_success: "",
  is_form_processing: false,
  cancel_success_timer: false,
});

const updateSuccessCancelTimer = () => {
  add_locker_data.cancel_success_timer = true;
};

const removeFormErr = (input_name)=>{

  if(input_name == 'name'){
    add_locker_data.form_error.name_err = "";
  }

  if(input_name == 'comment'){
    add_locker_data.form_error.comment_err = "";
  }


}

const assignFormErr = (errorsArr) => {
  // console.log(errorsArr);
  errorsArr.forEach((error) => {
    if (error.toLowerCase().indexOf("name") > -1) {
      add_locker_data.form_error.name_err = error;
    }

    
    if (error.toLowerCase().indexOf("comment") > -1) {
      add_locker_data.form_error.comment_err = error;
    }

   
  });
};

const checkForFormErrors = () => {
  let abort = false,
    errors_arr = [];
  if (add_locker_data.form_data.name == "") {
    abort = true;
    errors_arr.push("The Locker name or number field is required");
  }

 return {
    abort,
    errors_arr,
  };
};

const handleAddLockerForm = async () => {

   let err_check = checkForFormErrors();

   if(err_check.abort){
      assignFormErr(err_check.errors_arr);
   }else{

    try {
      add_locker_data.is_form_processing = true;
      add_locker_data.cancel_success_timer = false;
      const res = await axios.post("/lockers/handle-add-locker", add_locker_data.form_data);
      if (res?.data?.errors.length > 0) {
        assignFormErr(res?.data?.errors);
      } else {
        //success
        add_locker_data.custom_success =
          `Thanks, locker ${add_locker_data.form_data.name} has been added successfully`;
          setTimeout(() => {
          if (!add_locker_data.cancel_success_timer) {
            router.get("/");
          }
        }, 10000);
       
      }
    } catch (err) {
      //console.log(err);
      add_locker_data.custom_err = returnSystemErrorMsg();
    } finally {
      add_locker_data.is_form_processing = false;
    }
   }// end errors check
};

onMounted(() => {
  focusOnFirstInput(firstInput);
});

</script>
