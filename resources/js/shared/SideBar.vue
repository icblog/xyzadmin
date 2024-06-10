<template>
  <div class="side-bar-wrapper">
    <div class="menu-toggle-btn-wrapper">
      <AppButton
        :btnTitle="sideBarData.is_menu_on ? 'Close menu' : 'Open menu'"
        btnStyle="primary"
        :btnFunc="toggleMenu"
      >
        <span
          ><i :class="sideBarData.is_menu_on ? 'fas fa-times' : 'fa fa-bars'"></i
        ></span>
      </AppButton>
      <!-- menu-toggle-btn-wrapper -->
    </div>

    <div
      :class="{
        'side-bar-menu-wrapper': true,
        'menu-on': sideBarData.is_menu_on ? true : false,
        'menu-off': sideBarData.is_menu_on ? false : true,
      }"
    >
      <div class="side-bar-inner-wrapper">
        <section class="mb-3">
          <Accordion
            :key="1000"
            :activeIndex="sideBarData.currentlyActiveIndex"
            :itemIndex="1000"
            @update:itemIndex="sideBarData.currentlyActiveIndex = $event"
          >
            <template v-slot:accordion-trigger>
              <h6 class="pt-2">
                <i class="fa fa-user" aria-hidden="true"></i>
                {{ " " + $page.props.username }}
              </h6>
              <!-- //$page.props.isLoggedIn && $page.props.isAdmin -->
            </template>
            <template v-slot:accordion-content>
              <ul class="section-wrapper cf">
                <li @click="toggleMenu" v-if="$page.props.isLoggedIn">
                  <AppLink linkUrl="/logout">Logout</AppLink>
                </li>
                <li @click="toggleMenu" v-else>
                  <AppLink linkUrl="/login">Login</AppLink>
                </li>
              </ul>
            </template>
          </Accordion>
        </section>
        <!-- side-bar-inner-wrapper -->
      </div>
      <div v-show="$page.props.isLoggedIn" class="side-bar-menu-search-warpper">
        <LocalSearch
          :oldResultObj="sideBarData.default_menu_data"
          elementName="sidebar"
          inputPlaceHolderValue="Search menu..."
          @updateResultObj="updateMenuData"
        />
      </div>
      <div
        v-show="$page.props.isLoggedIn"
        class="side-bar-inner-wrapper side-bar-inner-wrapper2"
      >
        <section class="mb-3" v-for="(menu, index) in sideBarData.menu_data" :key="index">
          <Accordion
            :key="index"
            :activeIndex="sideBarData.currentlyActiveIndex"
            :itemIndex="index"
            @update:itemIndex="sideBarData.currentlyActiveIndex = $event"
          >
            <template v-slot:accordion-trigger>
              <h6 class="pt-2">{{ menu.name }}</h6>
            </template>
            <template v-slot:accordion-content>
              <ul class="cf">
                <li
                  v-for="(link, link_index) in menu.links"
                  :key="link_index"
                  @click="toggleMenu"
                >
                  <div
                    class="menu-link-wrapper"
                    v-if="
                      (link.restricted_type == 'admin' && $page.props.isAdmin) ||
                      (link.restricted_type == 'user' && $page.props.isLoggedIn)
                    "
                  >
                    <span
                      class="menu-active"
                      v-if="$page.component.toLowerCase() == link.component_name"
                    >
                      {{ link.link_name }}
                    </span>
                    <span v-else>
                      <AppLink
                        :linkType="link.is_ext ? 'ext' : 'int'"
                        :linkUrl="link.link_url"
                        >{{ link.link_name }}</AppLink
                      >
                    </span>
                  </div>
                </li>
              </ul>
            </template>
          </Accordion>
        </section>

        <!-- side-bar-inner-wrapper -->
      </div>

      <!-- end menu on menu off -->
    </div>
    <!-- side-bar-wrapper -->
  </div>
</template>

<script setup>
import { reactive, onMounted } from "vue";
import Accordion from "./Accordion";
import AppLink from "./AppLink";
import AppButton from "./AppButton";
import LocalSearch from "./LocalSearch";
import { returnSideBarData } from "../helper/sidebarMenuData";
const link_data = returnSideBarData();

const props = defineProps({
  currentlyActiveIndex: {
    type: Number,
    default: null,
  },
});

const sideBarData = reactive({
  currentlyActiveIndex: props.currentlyActiveIndex,
  is_menu_on: false,
  default_menu_data: link_data,
  menu_data: link_data,
});

const updateMenuData = (filtered_data) => {
  sideBarData.menu_data = filtered_data.arrObj;
};

const toggleMenu = () => {
  sideBarData.is_menu_on = !sideBarData.is_menu_on;
};

onMounted(() => {
  //console.log(sideBarData.menu_data[0].name);
});
</script>
