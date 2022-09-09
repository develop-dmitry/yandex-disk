<template>
  <form action="#">
    <button class="button" @click="selectFile">{{ fileText }}</button>
    <input type="file" id="file" ref="file" v-on:change="fileUpload()" v-show="false">
    <div class="form-error" data-role="form-error" v-show="isShowMessage">Ошибка</div>
    <button class="button button__margin" v-show="file">Загрузить</button>
  </form>
</template>

<style lang="scss" src="./file-form.scss"></style>

<script>
  export default {
    name: "file-form",
    data: () => {
      return {
        isShowMessage: false,
        file: "",
        fileText: "",
        excludeExtension: [".exe", ".sh"]
      }
    },
    methods: {
      selectFile() {
        document.querySelector("#file").click();
      },
      fileUpload() {
        this.hideMessage();
        if (this.checkFile(this.$refs.file.files[0].name)) {
          this.file = this.$refs.file.files[0];
          this.setButtonTextAsFileName();
        } else {
          this.showMessage("Запрещенное расширение файла");
          this.resetFile();
        }
      },
      checkFile(fileName) {
        let res = false;
        let extension = fileName.match(/\.\w+$/i);
        if (extension != null) {
          if (this.excludeExtension.indexOf(extension[0]) === -1) {
            res = true;
          }
        }
        return res;
      },
      showMessage(message) {
        this.isShowMessage = true;
        document.querySelector("[data-role=form-error]").innerText = message;
      },
      hideMessage() {
        this.isShowMessage = false;
      },
      resetFile() {
        document.querySelector("#file").value = "";
        this.file = "";
        this.setButtonDefaultText();
      },
      setButtonDefaultText() {
        this.fileText = "Выбрать файл";
      },
      setButtonTextAsFileName() {
        this.fileText = this.file.name;
      }
    },
    created() {
      this.setButtonDefaultText();
    }
  }
</script>