<template>
  <Layout pageTitle="add-user" pageIntro="Add user">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar :currentlyActiveIndex="0" />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="row pt-5">
              <div class="col text-right pt-2">
                <AppButton
                  :btnFunc="() => initiateAddCoworker()"
                  btnStyle="warn"
                  customClass="sign-in-out-btn mr-4 pt-3 pb-3"
                >
                  Add co-worker
                </AppButton>
              </div>
              <div class="col pt-2">
                <AppButton
                  :btnFunc="() => initiateAddRegularExtUser()"
                  btnStyle="primary2"
                  customClass="sign-in-out-btn ml-4 pt-3 pb-3"
                >
                  Add contrator
                </AppButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import SideBar from "../../shared/SideBar";
import Layout from "../../shared/Layout";
import AppButton from "../../shared/AppButton";

const initiateAddRegularExtUser = () => {
  router.visit("/user/add-contractor");
};

const initiateAddCoworker = () => {
  router.visit("/user/add-coworker");
};
</script>
