import Axios from "axios";
import EditInput from "../EditInput/EditInput.vue";

export default {
    name: "FileTable",
    components: {
        EditInput
    },
    data: () => {
        return {
            downloadLink: "",
        }
    },
    props: {
        files: Array
    },
    emits: [
        "file-delete",
        "file-rename",
        "error",
        "loader"
    ],
    methods: {
        deleteFile(file) {
            this.$emit("loader", true);
            this.hideMessage();
            Axios({
                method: "POST",
                url: "/ajax.php",
                params: {
                    action: "delete_file",
                    path: file.path
                }
            }).then(response => {
                if (response.data.result) {
                    this.$emit("file-delete");
                    this.$emit("error", {
                        message: "Файл успешно удален",
                        error: false
                    })
                } else {
                    this.$emit("error", {
                        message: response.data.message,
                    })
                }
                this.$emit("loader", false);
            })
        },

        downloadFile(file) {
            this.$emit("loader", true);
            this.hideMessage();
            Axios({
                method: "POST",
                url: "/ajax.php",
                params: {
                    action: "check_file_exist",
                    path: file.path
                }
            }).then(response => {
                if (response.data.result) {
                    window.location.href = "/download.php?path=" + file.path;
                } else {
                    this.$emit("error", {
                        message: response.data.message,
                    })
                }
                this.$emit("loader", false);
            })
        },

        renameFile(params) {
            this.$emit("loader", true);
            this.hideMessage();
            Axios({
                method: "POST",
                url: "/ajax.php",
                params: {
                    action: "rename_file",
                    path: this.files[params.index].path,
                    name: params.value
                }
            }).then(response => {
                if (response.data.result) {
                    this.$emit("error", {
                        message: "Файл успешно переименован",
                        error: false
                    })
                    this.$emit("file-rename");
                } else {
                    this.$emit("error", {
                        message: "Не удалось переименовать файл"
                    })
                }
                this.$emit("loader", false);
            })
        },

        hideMessage() {
            this.$emit("error", {show: false});
        },
    }
}