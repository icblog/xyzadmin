<template>
  <li v-if="$page.component.toLowerCase() != 'admin/admindashboard'">
    <AppLink linkUrl="/admin/dashboard" className="header-nav-link"> Dashboard </AppLink>
  </li>
  <li v-if="$page.component.toLowerCase() != 'blog/bloghome'">
    <AppLink linkUrl="/blog/post/latest" className="header-nav-link"> Blog home </AppLink>
  </li>
  <li v-if="$page.component.toLowerCase() != 'home'">
    <AppLink linkUrl="/" className="header-nav-link"> Site home </AppLink>
  </li>
</template>
<script setup>
import AppLink from "../AppLink";
</script>
