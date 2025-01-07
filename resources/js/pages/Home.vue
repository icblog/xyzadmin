<template>
  <Layout pageTitle="home" pageIntro="Home">
    <div class="container-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <SideBar />
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="mt-1 pt-1 pl-5 ml-5">
              <h6>Welcome to IC ADMIN</h6>
              <p>Please use the menu button on top left or links on the left.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from "../shared/Layout";
import SideBar from "../shared/SideBar";
</script>
