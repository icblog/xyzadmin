<template>
  <Layout pageTitle="admin-dashboard">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="page-intro-wrapper">
            <h1>Admin Dashboard</h1>
          </div>
        </div>
      </div>

      <div class="row pt-5">
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
          <AppLink
            linkUrl="/admin/create-post"
            className="box-shadow dashboard-task-link"
          >
            Create post
          </AppLink>

          <!-- end col-md-3 div -->
        </div>
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
          <AppLink linkUrl="/admin/allpost" className="box-shadow dashboard-task-link">
            All post
          </AppLink>

          <!-- end col-md-3 div -->
        </div>
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
          <AppLink linkUrl="/admin/categories" className="box-shadow dashboard-task-link">
            Categories
          </AppLink>
          <!-- end col-md-3 div -->
        </div>

        <!-- end row div -->
      </div>
    </div>
  </Layout>
</template>

<script>
import AppLink from "../../shared/AppLink.vue";
import Layout from "../../shared/Layout";
export default {
  components: { Layout, AppLink },
};
</script>
