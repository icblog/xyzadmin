<template>
  <div class="side-bar-wrapper">
    <!-- <div class="mb-3">
      <Accordion
        :key="0"
        :activeIndex="sideBarData.currentlyActiveIndex"
        :itemIndex="0"
        @update:itemIndex="sideBarData.currentlyActiveIndex = $event"
      >
        <template v-slot:accordion-trigger> <h6 class="pt-2">Manage User</h6> </template>
        <template v-slot:accordion-content>
          <ul>
            <li>Add user</li>
            <li>Edit user</li>
          </ul>
        </template>
      </Accordion>
    </div> -->

    <div class="mb-3">
      <Accordion
        :key="1"
        :activeIndex="sideBarData.currentlyActiveIndex"
        :itemIndex="1"
        @update:itemIndex="sideBarData.currentlyActiveIndex = $event"
      >
        <template v-slot:accordion-trigger>
          <h6 class="pt-2">Manage Visitors</h6>
        </template>
        <template v-slot:accordion-content>
          <ul>
            <li
              :class="currentMenuItemCliked == 'current visitors' ? 'menu-active' : ''"
              @click="
                () =>
                  currentMenuItemCliked == 'current visitors'
                    ? null
                    : handleMenuItemCliked('current visitors')
              "
            >
              Current visitors
            </li>

            <li
              :class="currentMenuItemCliked == 'view all visitors' ? 'menu-active' : ''"
              @click="
                () =>
                  currentMenuItemCliked == 'view all visitors'
                    ? null
                    : handleMenuItemCliked('view all visitors')
              "
            >
              View all visitors
            </li>
            <li>
              <AppLink linkType="ext" linkUrl="https://iv.icblog.uk/"
                >Sign visitors in/out</AppLink
              >
            </li>
          </ul>
        </template>
      </Accordion>
    </div>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import Accordion from "./Accordion";
import AppLink from "./AppLink";

const emit = defineEmits(["updateMenuItemClicked"]);

const props = defineProps({
  currentMenuItemCliked: {
    type: String,
    default: "",
  },
});

const sideBarData = reactive({
  currentlyActiveIndex: null,
});
const handleMenuItemCliked = (menuItemCliked) => {
  emit("updateMenuItemClicked", menuItemCliked);
};
</script>
