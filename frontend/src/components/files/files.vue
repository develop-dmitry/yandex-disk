<template>
  <div class="files">
    <div class="container">
      <file-form></file-form>
      <file-table :files="items"></file-table>
    </div>
  </div>
</template>

<style lang="scss" src="./files.scss"></style>

<script>
import FileTable from "../file-table/file-table.vue";
import FileForm from "../file-form/file-form.vue";
import Axios from "axios";

export default {
  name: "files",
  components: {
    FileTable,
    FileForm
  },
  data: () => {
    return {
      items: []
    }
  },
  created() {
    Axios({
      method: "POST",
      url: "/ajax.php",
      params: {
        action: "get_files"
      }
    }).then(response => {
      console.log(response)
      this.items = [];
      if (response.data.result) {
        response.data.items.forEach((value, index) => {
          this.items[index] = {
            name: value.name,
            path: value.path,
            created: value.created
          };
        })
      }
    })
  }
}
</script>