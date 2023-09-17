<template>
  <div class="row">
    <div class="visitors-card-wrapper col-md-12">
      <table v-if="visitorResult.length > 0">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Signed in</th>
            <th v-show="showSignOut" scope="col">Signed out</th>
            <th scope="col">Company</th>
            <th scope="col">Badge</th>
            <th scope="col">Visiting</th>
            <th v-show="showBtn" scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(visitor, i) in visitorResult" :key="visitor.id">
            <td data-label="Name">
              <span>{{ visitor.fname + " " + visitor.lname }}</span>
            </td>
            <td data-label="Signed in">
              <span>{{ returnFormattedDate(visitor.sign_in, true) }}</span>
            </td>
            <td v-show="showSignOut" data-label="Signed out">
              <span>{{
                visitor.sign_out == null
                  ? "-"
                  : returnFormattedDate(visitor.sign_out, true)
              }}</span>
            </td>
            <td data-label="Company">
              <span>{{ visitor.company }}</span>
            </td>
            <td data-label="Badge">
              <span>{{ visitor.badge }}</span>
            </td>
            <td data-label="Visiting">
              <span>{{ visitor.visiting }}</span>
            </td>

            <td v-show="showBtn" data-label="">
              <AppButton
                customClass="primary-btn"
                :btnFunc="() => handleSignOutVisitor(visitor.id)"
              >
                Sign Out
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
  visitorResult: {
    type: Array,
    default: [],
  },
  handleSignOutVisitor: {
    type: Function,
    default: null,
  },
  showBtn: {
    type: Boolean,
    default: true,
  },
  showSignOut: {
    type: Boolean,
    default: true,
  },
});
</script>
