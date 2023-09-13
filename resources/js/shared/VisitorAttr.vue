<template>
  <div v-if="returnCompanyAttrData().length > 0">
    <span v-for="(company, i) in returnCompanyAttrData()" :key="i">
      <AppButton btnType="button" customClass="primary-btn mr-2" :btnFunc="null">
        {{ company }}
      </AppButton>
    </span>
  </div>
</template>
<script setup>
import AppButton from "./AppButton";

const props = defineProps({
  vistorsResultSetData: {
    type: Array,
    default: [],
  },
});

const returnCompanyAttrData = () => {
  let tempArr = [];
  props.vistorsResultSetData.forEach((visitor) => {
    if (tempArr.indexOf(visitor.company) === -1) {
      tempArr.push(visitor.company);
    }
  });

  return tempArr;
};
</script>
