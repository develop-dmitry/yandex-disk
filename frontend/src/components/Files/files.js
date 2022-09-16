import FileTable from "../FileTable/FileTable.vue";
import FileForm from "../FileForm/FileForm.vue";
import Pagination from "../Pagination/Pagination.vue";
import Loader from "../Loader/Loader.vue";
import Axios from "axios";

export default {
    name: "Files",
    components: {
        FileTable,
        FileForm,
        Pagination,
        Loader
    },
    data: () => {
        return {
            isLoading: false,
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
        loaderHandler(isLoading) {
            this.isLoading = isLoading;
        },

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