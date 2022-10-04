import Ajax from "../Helpers/Ajax";
import FileInput from "../FileInput/FileInput.vue";
import {useFilesStore} from "../Stores/files-store";

export default {
    name: "FileForm",

    components: {
        FileInput
    },

    setup() {
        const filesStore = useFilesStore();

        return { filesStore }
    },

    data: () => {
        return {
            isUpload: false,
            file: "",
        }
    },

    computed: {
        uploadButtonText: function () {
            return (this.isUpload) ? "Загрузка..." : "Загрузить файл";
        },
    },

    methods: {
        async upload() {
            this.filesStore.setLoading(true);
            this.filesStore.hideMessage();
            this.isUpload = true;

            try {
                let formData = new FormData();
                formData.append("file", this.file);
                formData.append("action", "upload_file")

                let result = await this.filesStore.uploadFile(formData);

                if (result.success) {
                    this.filesStore.showMessage({
                        message: "Файл успешно загружен",
                        errorMessage: false
                    })
                } else {
                    this.filesStore.showMessage({
                        message: result.message
                    })
                }
            } catch (error) {
                this.filesStore.showMessage({
                    message: "Произошла ошибка"
                })
            } finally {
                this.filesStore.setLoading(false);
                this.isUpload = false;
            }
        },

        selectFile(file) {
            this.file = file;
        },
    },
}