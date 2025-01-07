<template>
  <Layout pageTitle="view-phones" pageIntro="View phones">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="3" />
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <!-- PHONE DETAILS GOES HERE -->
            <PhoneDetails :view_phone_res="view_phone_res" :errors="errors" />
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>
<script setup>
import PhoneDetails from "./PhoneDetails";
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";

const props = defineProps({
  errors: Object,
  view_phone_res: {},
});
</script>
