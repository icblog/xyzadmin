<template>
  <Layout pageTitle="add-phone" pageIntro="Add phone">
    <div class="container-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="4" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9"></div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import Layout from "../../shared/Layout";
import SideBar from "../../shared/SideBar";
import HandleMsg from "../../shared/HandleMsg";
import AppButton from "../../shared/AppButton";
import AppLink from "../../shared/AppLink";
import LoadingIndicator from "../../shared/LoadingIndicator";
</script>
