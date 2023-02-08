<template>
  <Layout pageTitle="resume">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mx-auto">
          <div class="page-intro-wrapper">
            <h1>Resume</h1>
          </div>
          <p>
            Click on the button below, this will open google drive link where you can
            download a copy of my resume thank you.
          </p>
          <div class="pt-3 pb-3">
            <AppLink :linkUrl="resumeLink" linkType="ext" className="primary-btn"
              >Download Resume</AppLink
            >
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
import Layout from "../shared/Layout";
import AppLink from "../shared/AppLink.vue";
import { returnResumeLink } from "../helper/util";

export default {
  components: { Layout, AppLink },
  data() {
    return {
      resumeLink: returnResumeLink(),
    };
  },
};
</script>
