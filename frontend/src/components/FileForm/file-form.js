import Axios from "axios";
import FileInput from "../FileInput/FileInput.vue";

export default {
    name: "FileForm",
    components: {
        FileInput
    },
    data: () => {
        return {
            isUpload: false,
            file: "",
        }
    },
    emits: [
        "file-upload",
        "error",
        "loader"
    ],
    computed: {
        uploadButtonText: function () {
            return (this.isUpload) ? "Загрузка..." : "Загрузить файл";
        },
    },
    methods: {
        upload() {
            this.hideMessage();
            this.isUpload = true;
            let formData = new FormData();
            formData.append("file", this.file);
            formData.append("action", "upload_file")
            Axios.post(
                "/ajax.php",
                formData,
                {
                    'Content-Type': 'multipart/form-data'
                }
            ).then(response => {
                if (response.data.result) {
                    this.$emit("file-upload");
                    this.$emit("error", {
                        message: "Файл успешно загружен",
                        error: false
                    })
                } else {
                    this.$emit("error", {
                        message: response.data.message
                    })
                }
                this.isUpload = false;
            })
        },

        selectFile(file) {
            this.file = file;
        },

        hideMessage() {
            this.$emit("error", {show: false});
        },

        errorHandler(params) {
            this.$emit("error", params);
        }
    },
    watch: {
        isUpload: function () {
            this.$emit("loader", this.isUpload);
        }
    }
}