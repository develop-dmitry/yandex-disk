<template>
  <form action="#">
    <button class="button" @click="selectFile">{{ fileText }}</button>
    <input type="file" id="file" ref="file" v-on:change="fileUpload()" v-show="false">
  </form>
</template>

<style lang="scss" src="./file-form.scss"></style>

<script>
  export default {
    name: "file-form",
    data: () => {
      return {
        isOpen: false,
        file: "",
        fileText: "Загрузить файл"
      }
    },
    methods: {
      selectFile() {
        console.log(document.querySelector("#file").value);
        document.querySelector("#file").click();
      },
      fileUpload() {
        this.file = this.$refs.file.files[0];
      }
    },
    watch: {
      file: function () {
        this.fileText = this.file.name;
      }
    }
  }
</script>