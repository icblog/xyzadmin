<template>
  <section class="mb-2">
    <div
      v-if="props.existingPostImages.length > 0"
      class="preview-input-images-wrapper p-3"
    >
      <div class="row">
        <div class="col-md-12">
          <h6>
            Existing post {{ props.existingPostImages.length > 1 ? "images" : "image" }}
          </h6>
        </div>
        <div
          v-for="(img, i) in props.existingPostImages"
          :key="i"
          class="text-center col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-2"
        >
          <div className="remove-image-badge-wrapper">
            <h4>
              <span
                @click="handleRemoveExistingImage(i)"
                className="remove-image-badge badge badge-danger btn-large no-border-radius"
              >
                x
              </span>
            </h4>

            <img className="mx-auto d-block img-fluid" :src="img.imgUrl" alt="" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive } from "vue";
import { removeItemFromArrayByIndex } from "../../helper/util";
//import Multiselect from "vue-multiselect";
const emit = defineEmits();
const props = defineProps({
  existingPostImages: {
    type: Array || Object,
    default: [],
  },
});

const uploadData = reactive({
  tempUploadUrls: [],
});

const handleRemoveExistingImage = (index) => {
  if (window.confirm(`Delete this image? please note this can not be undone`)) {
    let tempArrObj = props.existingPostImages,
      objTobedeleted = props.existingPostImages[index],
      resArrObj = [];
    resArrObj = removeItemFromArrayByIndex(index, tempArrObj);
    //console.log(objTobedeleted);

    emit("updateExistingimages", {
      resArrObj: resArrObj,
      objTobedeleted: objTobedeleted,
    });
  } //End window confirm
};
</script>
