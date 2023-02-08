<template>
  <Layout pageTitle="home">
    <div class="container homepage-container">
      <div class="row">
        <div class="col-md-10 mx-auto">
          <div class="page-intro-wrapper">
            <h1>Hi, I'm Isaac Cobbinah.</h1>
            <p>
              Highly motivated self-taught full-stack php web developer with a focus on
              responsive design and accessibility seeking to kick start a career in web
              development and services.
              <AppLink linkUrl="/about" className="more-about-me-link-home-page">
                More about me</AppLink
              >
            </p>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from "../shared/Layout";
import AppLink from "../shared/AppLink";
</script>
