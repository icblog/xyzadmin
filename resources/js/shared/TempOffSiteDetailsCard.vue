<template>
  <div class="row">
    <div class="visitors-card-wrapper col-md-12">
      <table v-if="temp_offsite_result.length > 0">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Signed out</th>
            <th v-show="show_sign_in" scope="col">Signed in</th>
            <th scope="col">Department/Company</th>
            <th v-show="show_btn" scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(visitor, i) in temp_offsite_result" :key="visitor.id">
            <td data-label="Name">
              <span>{{ visitor.fname + " " + visitor.lname }}</span>
            </td>
            <td data-label="Signed out">
              <span>{{ returnFormattedDate(visitor.time_out, true) }}</span>
            </td>
            <td v-show="show_sign_in" data-label="Signed in">
              <span>{{
                visitor.time_in == null
                  ? "---"
                  : returnFormattedDate(visitor.time_in, true)
              }}</span>
            </td>
            <td data-label="Department/Company">
              <span>{{ visitor.depart_comp }}</span>
            </td>

            <td v-show="show_btn" data-label="" class="pl-5 pt-3 pb-3">
              <AppButton
                customClass="primary-btn"
                :btnFunc="() => handleSignInVisitor(visitor.id)"
              >
                Sign in
              </AppButton>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import AppButton from "./AppButton";
import { returnFormattedDate } from "../helper/util";
const props = defineProps({
  temp_offsite_result: {
    type: Array,
    default: [],
  },
  handleSignInVisitor: {
    type: Function,
    default: null,
  },
  show_btn: {
    type: Boolean,
    default: true,
  },
  show_sign_in: {
    type: Boolean,
    default: true,
  },
});
</script>
