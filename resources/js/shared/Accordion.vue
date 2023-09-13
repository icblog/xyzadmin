<template>
  <div class="accordion-wrapper">
    <div @click="updateIndex" class="accordion-trigger cf">
      <div class="float-left">
        <span class="collapsed-heading"><slot name="accordion-trigger"></slot></span>
      </div>
      <div class="float-right pr-3 pt-1">
        <span class="collapsed-icon"
          ><i
            :class="{
              'fa fa-chevron-up': activeIndex === itemIndex,
              'fa fa-chevron-down': activeIndex != itemIndex,
            }"
          ></i
        ></span>
      </div>
    </div>
    <transition name="expand">
      <div class="accordion-content-wrapper">
        <div v-show="activeIndex === itemIndex" class="accordion-content" ref="content">
          <slot name="accordion-content"></slot>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { Transition } from "vue";
export default {
  components: {
    Transition,
  },
  data() {
    return {
      height: 0,
    };
  },
  props: {
    activeIndex: {
      type: Number,
      default: null,
    },
    itemIndex: {
      type: Number,
      default: null,
    },
  },
  methods: {
    updateIndex() {
      //console.log("index updated:", this.itemIndex);
      if (this.activeIndex === this.itemIndex) {
        this.$emit("update:itemIndex", null);
      } else {
        this.$emit("update:itemIndex", this.itemIndex);
      }
    },
  },
};
</script>
