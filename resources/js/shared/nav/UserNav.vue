<template>
  <li v-if="$page.component.toLowerCase() == 'blog/bloghome' && !$page.props.isLoggedIn">
    <AppLink linkUrl="/login" className="header-nav-link"> Login/Register </AppLink>
  </li>

  <li v-if="$page.component.toLowerCase() != 'blog/bloghome'">
    <AppLink linkUrl="/blog/post/latest" className="header-nav-link"> Blog </AppLink>
  </li>

  <li v-if="$page.component.toLowerCase() != 'contact'">
    <AppLink linkUrl="/contact" className="header-nav-link"> Contact </AppLink>
  </li>

  <li v-if="$page.component.toLowerCase() != 'resume'">
    <AppLink linkUrl="/resume" className="header-nav-link"> Resume </AppLink>
  </li>
</template>

<script setup>
import AppLink from "../AppLink";
</script>
