<template>
  <Layout :pageTitle="homeData.menuItemClicked" :pageIntro="homeData.menuItemClicked">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar
              @updateMenuItemClicked="updateMenuItemClicked"
              :currentMenuItemCliked="homeData.menuItemClicked"
            />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div v-if="homeData.isMenuItemBeenClicked">
              <LoadingIndicator />
            </div>
            <div v-else>
              <section v-show="homeData.menuItemClicked == 'dashboard'">
                <Dashboard :menuItemClicked="homeData.menuItemClicked" />
              </section>
              <section v-show="homeData.menuItemClicked == 'current visitors'">
                <CurrentVisitors :menuItemClicked="homeData.menuItemClicked" />
              </section>
              <section v-show="homeData.menuItemClicked == 'view all visitors'">
                <ViewAllVisitors :menuItemClicked="homeData.menuItemClicked" />
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { reactive } from "vue";
import Layout from "../shared/Layout";
import SideBar from "../shared/SideBar";
import CurrentVisitors from "./CurrentVisitors";
import ViewAllVisitors from "./ViewAllVisitors";
import Dashboard from "./Dashboard";
import LoadingIndicator from "../shared/LoadingIndicator";

const homeData = reactive({
  menuItemClicked: "dashboard",
  isMenuItemBeenClicked: false,
});

const updateMenuItemClicked = (menuItemClicked) => {
  homeData.isMenuItemBeenClicked = true;
  setTimeout(() => {
    homeData.isMenuItemBeenClicked = false;
    homeData.menuItemClicked = menuItemClicked;
  }, 10);
};
</script>
