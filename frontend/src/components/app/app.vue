<template>
  <div class="files">
    <div class="container">
      <file-form></file-form>
      <file-table :files="files"></file-table>
    </div>
  </div>
</template>

<style lang="scss" src="./app.scss"></style>

<script>
  import FileTable from "../file-table/file-table.vue";
  import FileForm from "../file-form/file-form.vue";

  export default {
    name: "App",
    components: {
      FileTable,
      FileForm
    },
    data: () => {
      return {
        files: [
          {
            title: "test.png",
            owner: "Дмитрий К.",
            size: "35 КБ"
          },
          {
            title: "test.png",
            owner: "Дмитрий К.",
            size: "35 КБ"
          }
        ]
      }
    }
  }
</script>