import EditInput from "../EditInput/EditInput.vue";
import { useFilesStore } from "../Stores/files-store";
import {onMounted} from "vue";

export default {
    name: "FileTable",

    components: {
        EditInput
    },

    setup() {
        const filesStore = useFilesStore();

        onMounted(async () => {
            filesStore.setLoading(true);

            try {
                let result = await filesStore.getFiles();

                if (!result.success) {
                    filesStore.showMessage({
                        message: result.message
                    })
                }
            } catch (error) {
                filesStore.showMessage({
                    message: "Произошла ошибка"
                })
            } finally {
                filesStore.setLoading(false);
            }
        })

        return { filesStore }
    },

    methods: {
        async deleteFile(file) {
            this.filesStore.setLoading(true);
            this.filesStore.hideMessage();

            try {
                let result = await this.filesStore.deleteFile({
                    path: file.path
                })

                if (result.success) {
                    this.filesStore.showMessage({
                        message: "Файл успешно удален",
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
            }
        },

        async downloadFile(file) {
            this.filesStore.setLoading(true);
            this.filesStore.hideMessage();

            try {
                let result = await this.filesStore.checkFileExist({
                    path: file.path,
                });

                if (result.success) {
                    window.location.href = "/download?path=" + file.path;
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
            }
        },

        async renameFile(params) {
            this.filesStore.setLoading(true);
            this.filesStore.hideMessage();

            try {
                let result = await this.filesStore.renameFile({
                    path: this.filesStore.files[params.index].path,
                    name: params.value
                })

                if (result.success) {
                    this.filesStore.showMessage({
                        message: "Файл успешно переименован",
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
            }
        },
    }
}