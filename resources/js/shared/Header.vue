<template>
  <header id="main-header">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="header-content-wrapper">
            <div class="left-content-wrapper">
              <Logo />
            </div>
            <!-- End left-content-wrapper -->
            <div
              :class="
                isMenuOn
                  ? 'middle-content-wrapper menu-on'
                  : 'middle-content-wrapper menu-off'
              "
            >
              <ul>
                <AdminNav v-if="$page.props.isLoggedIn && $page.props.isAdmin" />
                <UserNav v-else />
              </ul>
            </div>
            <!-- End middle-content-wrapper -->
            <div class="right-content-wrapper">
              <ul>
                <li
                  v-if="
                    $page.component.toLowerCase() == 'blog/bloghome' ||
                    $page.component.toLowerCase() == 'blog/blogsingle'
                  "
                >
                  <button
                    type="button"
                    title="Search"
                    class="search-btn"
                    @click="toggleSearch"
                  >
                    <span
                      ><i :class="isSearchOn ? 'fa fa-times' : 'fa fa-search'"></i
                    ></span>
                  </button>
                </li>

                <li>
                  <button
                    type="button"
                    title="Open menu"
                    class="menu-btn show-on-mobile hide-on-desktop"
                    @click="toggleMenu"
                  >
                    <span><i :class="isMenuOn ? 'fas fa-times' : 'fa fa-bars'"></i></span>
                  </button>
                </li>

                <li
                  v-if="
                    $page.props.isLoggedIn &&
                    $page.component.toLowerCase() != 'auth/logout'
                  "
                >
                  <span class="account-link">
                    <div class="dropdown">
                      <a href="/user/profile" title="Account" class="hello-user">
                        <i class="fa fa-user"></i>
                      </a>
                      <div class="dropdown-content">
                        <span class="span-user-name hello-user"
                          >Hi, {{ $page.props.username }}</span
                        >

                        <AppLink v-if="$page.props.isAdmin" linkUrl="/admin/dashboard">
                          Admin
                        </AppLink>

                        <AppLink linkUrl="/user/profile"> Profile </AppLink>

                        <AppLink linkUrl="/logout"> Log Out </AppLink>
                      </div>
                    </div>
                  </span>
                </li>
              </ul>
            </div>
            <!-- End right-content-wrapper -->
          </div>
          <!-- END COL-MD-12 -->
        </div>
        <!-- END HEADER CONTENT WRAPPER -->
      </div>
      <!-- END ROW -->
    </div>
    <!-- END CONTAINER -->
    <!-- Blog main search form -->

    <BlogSearch
      v-show="
        (isSearchOn && $page.component.toLowerCase() == 'blog/bloghome') ||
        (isSearchOn && $page.component.toLowerCase() == 'blog/blogsingle')
      "
      :isSearchOn="isSearchOn"
    />
  </header>
</template>
<script>
import AppLink from "./AppLink.vue";
import Logo from "./Logo";
import UserNav from "./nav/UserNav";
import AdminNav from "./nav/AdminNav";
import BlogSearch from "../pages/blog/BlogSearch.vue";

export default {
  components: {
    AppLink,
    Logo,
    UserNav,
    AdminNav,
    BlogSearch,
  },
  data() {
    return {
      isMenuOn: false,
      isSearchOn: false,
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOn = !this.isMenuOn;
      if (this.isSearchOn) {
        this.isSearchOn = false;
      }
    },

    toggleSearch() {
      this.isSearchOn = !this.isSearchOn;
      if (this.isMenuOn) {
        this.isMenuOn = false;
      }
    },
  },
};
</script>
