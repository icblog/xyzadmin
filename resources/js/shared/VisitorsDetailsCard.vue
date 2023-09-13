<template>
 <div class="visitors-card-wrapper box-shadow">
    <Accordion
      :key="visitor.id"
      :activeIndex="visitorsDetailData.currentlyActiveIndex"
      :itemIndex="visitor.id"
      @update:itemIndex="visitorsDetailData.currentlyActiveIndex = $event"
    >
      <template v-slot:accordion-trigger>
        <span>{{ visitor.fname + " " + visitor.lname }}</span>
      </template>
      <template v-slot:accordion-content>
        <div class="row">
          <div class="col-md-5 detail-col1">
            <ul>
              <li>
                Signed in:
                <span>{{ returnFormattedDate(visitor.sign_in, true) }}</span>
              </li>
              <li v-show="!showBtn">
                Signed out:
                <span>{{
                  visitor.sign_out == null
                    ? "..............."
                    : returnFormattedDate(visitor.sign_in, true)
                }}</span>
              </li>
              <li>
                Company: <span>{{ visitor.company }}</span>
              </li>
              <li>
                Visiting: <span>{{ visitor.visiting }}</span>
              </li>
            </ul>
          </div>
          <div class="col-md-5 detail-col2">
            <ul>
              <li>
                Reason: <span>{{ visitor.reason }}</span>
              </li>
              <li>
                Badge: <span>{{ visitor.badge }}</span>
              </li>
              <li>
                Phone: <span>{{ visitor.phone }}</span>
              </li>
            </ul>
          </div>
          <div class="col-md-2 detail-col3">
            <span v-show="showBtn">
              <AppButton
                customClass="primary-btn"
                :btnFunc="() => handleSignOutVisitor(visitor.id)"
              >
                Sign Out
              </AppButton>
            </span>
          </div>
        </div>
      </template>
    </Accordion>
  </div>

</template>

<script setup>
import { reactive } from "vue";
import AppButton from "./AppButton";
import Accordion from "./Accordion";
import { returnFormattedDate } from "../helper/util";
const props = defineProps({
  visitor: {
    type: Object,
    default: {},
  },
  handleSignOutVisitor: {
    type: Function,
    default: null,
  },
  showBtn: {
    type: Boolean,
    default: true,
  },
});

const visitorsDetailData = reactive({
  currentlyActiveIndex: null,
});
</script>
