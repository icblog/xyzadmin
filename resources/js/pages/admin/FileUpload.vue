<template>
  <section class="mb-2">
    <div class="form-group">
      <label class="form-label" for="Post-images">Post-images</label
      ><span> (Optional)</span>
      <div class="text-center">
        <input type="file" id="upload" hidden multiple @change="handleImageFileChange" />
        <label for="upload" class="upload-label">Choose file</label>
      </div>
      <div
        v-if="uploadData.tempUploadUrls.length > 0"
        class="preview-input-images-wrapper p-3"
      >
        <div class="row">
          <div class="col-md-12">
            <h6>
              {{ uploadData.tempUploadUrls.length > 1 ? "Images" : "Image" }} to be
              uploaded
            </h6>
          </div>
          <div
            v-for="(img, i) in uploadData.tempUploadUrls"
            :key="i"
            class="text-center col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-2"
          >
            <div className="remove-image-badge-wrapper">
              <h4>
                <span
                  @click="handleRemoveImage(i)"
                  className="remove-image-badge badge badge-danger btn-large no-border-radius"
                >
                  x
                </span>
              </h4>

              <img className="mx-auto d-block img-fluid" :src="img" alt="" />
            </div>
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
  postImages: {
    type: Array || Object,
    default: [],
  },
});

const uploadData = reactive({
  tempUploadUrls: [],
});

const handleImageFileChange = (e) => {
  let tempImgsUrl = [...uploadData.tempUploadUrls],
    fileArray = [...props.postImages],
    files = e.target.files;
  for (let i = 0; i < files.length; i++) {
    tempImgsUrl.push(URL.createObjectURL(files[i]));
    fileArray.push(files[i]);
  } //end for loop

  //console.log("Update 1", fileArray);
  uploadData.tempUploadUrls = tempImgsUrl;
  emit("updateimages", fileArray);
};

const handleRemoveImage = (index) => {
  let newArr1 = [],
    newArr2 = props.postImages,
    tempArr1 = uploadData.tempUploadUrls,
    dt = new DataTransfer(); // To hold the Filelist
  //Loop and hold files that does not match the index
  for (let i = 0; i < props.postImages.length; i++) {
    let file = props.postImages[i];
    if (i !== index) {
      dt.items.add(file);
    }
  } //end for loop

  //Remove iage from view
  newArr1 = removeItemFromArrayByIndex(index, tempArr1);
  newArr2 = removeItemFromArrayByIndex(index, newArr2);

  //console.log("Update 2", newArr2);
  // set new state data
  uploadData.tempUploadUrls = newArr1;
  emit("updateimages", newArr2);
  //emit("updateimages", dt.files);
};
</script>
