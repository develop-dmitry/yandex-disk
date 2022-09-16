<template>
  <div class="files">
    <div class="container">
      <div class="alert alert__margin-bottom"
           :class="{'alert__info': !errorMessage, 'alert__warning': errorMessage}"
           v-if="showMessage">
        {{ message }}
      </div>
      <file-form
          @file-upload="changeFileCount"
          @error="errorHandler"></file-form>
      <file-table
          @file-delete="changeFileCount"
          @file-rename="getFiles"
          @error="errorHandler"
          :files="items"></file-table>
      <pagination :pages="this.pages"
                  :current-page="offset / limit"
                  @select-page="changePage"></pagination>
    </div>
  </div>
</template>

<style lang="scss" src="./files.scss"></style>

<script>
import FileTable from "../file-table/file-table.vue";
import FileForm from "../file-form/file-form.vue";
import Pagination from "../pagination/pagination.vue";
import Axios from "axios";

export default {
  name: "files",
  components: {
    FileTable,
    FileForm,
    Pagination
  },
  data: () => {
    return {
      limit: 20,
      offset: 0,
      pages: 0,
      currentPage: 1,
      items: [],
      showMessage: false,
      errorMessage: false,
      message: ""
    }
  },
  methods: {
    errorHandler(params) {
      this.showMessage = params.show ?? true;
      this.errorMessage = params.error ?? true;
      this.message = params.message ?? "";
    },

    getFiles() {
      Axios({
        method: "POST",
        url: "/ajax.php",
        params: {
          action: "get_files",
          limit: this.limit,
          offset: this.offset
        }
      }).then(response => {
        console.log(response);
        this.items = [];
        if (response.data.result) {
          response.data.items.forEach((value, index) => {
            this.items[index] = {
              name: value.name,
              path: value.path,
              created: value.created
            };
          })
        } else {
          this.errorHandler({
            message: response.data.message
          })
        }
      })
    },

    getPages() {
      Axios({
        method: "POST",
        url: "/ajax.php",
        params: {
          action: "get_file_pages",
          limit: this.limit,
        }
      }).then(response => {
        this.pages = response.data.pages;
        if (this.currentPage > this.pages) {
          this.changePage(this.pages);
        }
      })
    },

    changeFileCount() {
      this.getFiles();
      this.getPages();
    },

    changePage(page) {
      this.offset = this.limit * page - this.limit;
      this.getFiles();
      this.currentPage = page;
    }
  },

  created() {
    this.changeFileCount();
  }
}
</script>