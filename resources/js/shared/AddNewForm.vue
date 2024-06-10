<template>
  <div :class="show_wrapper_div ? 'form-wrapper' : ''">
    <section v-if="add_new_form_data.is_form_processing"><LoadingIndicator /></section>
    <section v-else>
      <form @submit.prevent="handleAddNewFormSubmit">
        <label class="form-label" :for="label_name"
          ><span v-show="add_new_form_data.add_new_form_success_msg == ''">
            {{ label_name }}</span
          >
          <br />
          <span v-if="showAddNewFormErr()" class="text-danger bolded small">{{
            add_new_form_data.add_new_err_msg
          }}</span>
          <span
            v-else-if="add_new_form_data.add_new_form_success_msg != ''"
            class="text-success bolded"
            >{{ add_new_form_data.add_new_form_success_msg }}</span
          >
          <span v-else>Name*</span>
        </label>
        <div
          v-show="add_new_form_data.add_new_form_success_msg == ''"
          class="input-group mb-3"
        >
          <input
            type="text"
            v-model="add_new_form_data.name"
            class="form-control"
            @focus="hideAddNewFormErr"
          />
          <div class="input-group-append">
            <AppButton btnType="submit" customClass="btn-primary">Save</AppButton>
          </div>
        </div>
        <p v-show="add_new_form_data.add_new_form_success_msg == ''" class="small">
          All fields marked with a * are mandatory
        </p>
      </form>
    </section>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import AppButton from "../../shared/AppButton";
import LoadingIndicator from "../../shared/LoadingIndicator";
import axios from "../../api/axios";
import { returnSystemErrorMsg } from "../../helper/util";

const props = defineProps({
  show_wrapper_div: {
    type: Boolean,
    default: false,
  },

  label_name: {
    type: String,
    default: "",
  },

  end_point: {
    type: String,
    default: "",
  },

  redirect_end_point: {
    type: String,
    default: "",
  },
});

const add_new_form_data = reactive({
  name: "",
  is_form_processing: false,
  add_new_err_msg: "",
  add_new_form_success_msg: "",
});
const showAddNewFormErr = () => {
  if (add_new_form_data.add_new_err_msg != "") {
    return true;
  } else {
    return false;
  }
};

const hideAddNewFormErr = () => {
  add_new_form_data.add_new_err_msg = "";
};

const handleAddNewFormSubmit = () => {
  let abort = false;
  if (add_new_form_data.name == "") {
    abort = true;
    add_new_form_data.add_new_err_msg = `*Please enter ${props.label_name} name`;
  }
  if (!abort) {
    //Post the form
    add_new_form_data.is_form_processing = true;
    setTimeout(async () => {
      try {
        const res = await axios.post(end_point, {
          name: add_new_form_data.name,
        });

        if (res?.data?.outcome === true) {
          add_new_form_data.add_new_form_success_msg = `${props.label_name}  created successfully`;
          add_new_form_data.name = "";
          setTimeout(() => {
            router.visit(props.redirect_end_point, { method: "get" });
          }, 500);
        } else {
          //console.log(res);
          add_new_form_data.add_new_err_msg = res?.data?.outcome[0];
        }
      } catch (err) {
        add_new_form_data.add_new_err_msg = returnSystemErrorMsg();
      } finally {
        add_new_form_data.is_form_processing = false;
      }
    }, 1000);
  }
};
</script>
