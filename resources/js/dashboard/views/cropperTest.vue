<template>
    <vue-cropper 
        ref="vueCropperRef"
        :src="imgSrc"
        alt="Source Image"
    />
  </template>
  <script>
  import {ref, onMounted} from 'vue'
  import VueCropper from '@ballcat/vue-cropper';
  import 'cropperjs/dist/cropper.css';
  
  export default {
    components: {
      VueCropper,
    },
    setup() {
      const imgSrc = ref('../../IMG/logo.png')
      const vueCropperRef = ref(null);
  
      onMounted(() => {
        console.log(vueCropperRef.value.getData());
      });
  
      return {
        imgSrc,
        vueCropperRef
      };
    }
  };
  </script>