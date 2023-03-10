<template>
  <footer className="footer-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 pb-4">
          <h6>Site links</h6>
          <i class="fa fa-home"></i><AppLink linkUrl="/"> Home</AppLink><br />
          <i class="fa fa-question-circle"></i><AppLink linkUrl="/about"> About</AppLink
          ><br />
          <i class="fa fa-briefcase"></i><AppLink linkUrl="/resume"> Resume</AppLink
          ><br />
          <i class="fab fa-blogger"></i
          ><AppLink linkUrl="/blog/post/latest"> Blog</AppLink>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 pb-4">
          <h6>Get intouch</h6>

          <p>
            <i class="fas fa-sms"></i>
            <AppLink linkUrl="/contact"> Contact</AppLink><br />
            <i class="fab fa-github-square"></i>
            <AppLink linkUrl="https://github.com/icblog" linkType="ext"> Github</AppLink
            ><br />
            <i className="fa fa-envelope" aria-hidden="true"></i> info@icblog.uk <br />
          </p>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 pb-4">
          <h6>Useful links</h6>
          <i class="fa fa-school"></i
          ><AppLink linkUrl="https://www.w3schools.com/" linkType="ext">
            W3C school</AppLink
          ><br />
          <i class="fa fa-rocket"></i
          ><AppLink linkUrl="https://stackoverflow.com/" linkType="ext">
            Stack overflow</AppLink
          ><br />
          <i class="fab fa-medium-m"></i>
          <AppLink linkUrl="https://medium.com" linkType="ext"> Medium.com</AppLink><br />

          <i className="fa fa-copyright" aria-hidden="true"></i> {{ copyRightData }}
        </div>
      </div>
    </div>
  </footer>
  <transition name="fade">
    <div class="scroll-to-topbtn" v-show="scY > 300">
      <AppButton btnStyle="primary" :btnFunc="toTop"
        ><i class="fa fa-chevron-up"></i
      ></AppButton>
    </div>
  </transition>
</template>

<script>
import AppButton from "./AppButton.vue";
import AppLink from "./AppLink.vue";
export default {
  components: {
    AppButton,
    AppLink,
  },
  data() {
    return {
      copyRightData: `${new Date().getFullYear()} icblog.com`,
      scTimer: 0,
      scY: 0,
    };
  },
  methods: {
    handleScrollToTopBtn: function () {
      if (this.scTimer) return;
      this.scTimer = setTimeout(() => {
        this.scY = window.scrollY;
        clearTimeout(this.scTimer);
        this.scTimer = 0;
      }, 100);
    },
    toTop: function () {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    },
  },

  mounted() {
    window.addEventListener("scroll", this.handleScrollToTopBtn);
  },
};
</script>
