<template>
  <footer className="footer-wrapper text-center">
    <p><i className="fa fa-copyright" aria-hidden="true"></i> {{ copyRightData }}</p>
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
export default {
  components: {
    AppButton,
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
