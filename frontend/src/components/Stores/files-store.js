import {defineStore} from "pinia";
import Ajax from "../Helpers/Ajax"

const api = "/api/";

export const useFilesStore = defineStore('files', {
    state: () => ({
        files: [],
        pageCount: 1,
        currentPage: 1,
        limit: 5,
        offset: 0,
        errorMessage: false,
        visibleMessage: false,
        message: "",
        isLoading: false
    }),

    actions: {
        async getFiles() {
            try {
                let result = await new Ajax().post(api + "get-files", {
                    limit: this.limit,
                    offset: this.offset
                })

                let files = [];

                if (result.success) {
                    result.response.items.forEach((item) => {
                        files.push({
                            name: item.name,
                            path: item.path,
                            created: item.created
                        })
                    })
                } else {
                    this.showMessage({
                        message: result.message
                    })
                }

                await this.getPages();
                this.files = files;

                return result;
            } catch (error) {
                this.files = [];

                throw error;
            }
        },

        async getPages() {
            try {
                let result = await new Ajax().post(api + "get-file-pages", {
                    limit: this.limit
                });

                this.pageCount = result.response.pages;

                if (this.pageCount < this.currentPage) {
                    await this.changePage(this.pageCount);
                }
            } catch (error) {
                this.reset();

                throw error;
            }
        },

        async changePage(page) {
            this.offset = this.limit * page - this.limit;
            await this.getFiles();
            this.currentPage = page;
        },

        async uploadFile(params) {
            let result = await new Ajax().post(api + "upload-file", params);

            if (result.success) {
                await this.getFiles();
            }

            return result;
        },

        async checkFileExist(params) {
            return await new Ajax().post(api + "check-file-exist", params);
        },

        async deleteFile(params) {
            let result = await new Ajax().post(api + "delete-file", params);

            if (result.success) {
                await this.getFiles();
            }

            return result;
        },

        async renameFile(params) {
            let result = await new Ajax().post(api + "rename-file", params);

            if (result.success) {
                await this.getFiles();
            }

            return result;
        },

        showMessage(params) {
            this.visibleMessage = params.visible ?? true;
            this.message = params.message ?? "";
            this.errorMessage = params.errorMessage ?? true;
        },

        hideMessage() {
            this.showMessage({
                visible: false,
                errorMessage: false
            })
        },

        reset() {
            this.pageCount = 1;
            this.currentPage = 1;
            this.offset = 0;
        },

        setLoading(isLoading) {
            this.isLoading = isLoading;
        }
    }
})