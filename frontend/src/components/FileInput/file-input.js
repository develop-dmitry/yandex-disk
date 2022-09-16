export default {
    name: "FileInput",
    data: () => {
        return {
            file: "",
        }
    },

    computed: {
        fileText: function () {
            return (this.file) ? this.file.name : "Выбрать файл";
        }
    },

    props: {
        excludeExtension: {
            type: Array,
        },
        maxSize: {
            type: Number,
            default() {
                return 10;
            }
        },
        inputId: {
            type: String,
            required: true
        },
        reset: {
            type: Boolean
        }
    },

    emits: [
        "error",
        "select-file"
    ],

    methods: {
        openSelectWindow() {
            document.querySelector("#"+this.inputId).click();
        },

        selectFile() {
            this.hideMessage();
            if (this.checkFile(this.$refs.file.files[0])) {
                this.file = this.$refs.file.files[0];
            } else {
                this.resetFile();
            }
        },

        checkFile(file) {
            if (!this.checkSize(file.size)) {
                this.$emit("error", {
                    message: "Загружаемый файл больше " + this.maxSize + " МБ"
                })
                return false;
            }

            if (!this.checkName(file.name)) {
                this.$emit("error", {
                    message: "Запрещенное расширение файла"
                })
                return false;
            }

            return true;
        },

        checkName(name) {
            let result = false;
            let extension = name.match(/\.\w+$/i);
            if (extension != null) {
                if (this.excludeExtension.indexOf(extension[0]) === -1) {
                    result = true;
                }
            }
            return result;
        },

        checkSize(size) {
            return this.convertByteToMegabyte(size) < this.maxSize;
        },

        resetFile() {
            document.querySelector("#"+this.inputId).value = "";
            this.file = "";
        },

        convertByteToMegabyte(byte) {
            return byte / 1024 / 1024;
        },

        hideMessage() {
            this.$emit("error", {show: false});
        },
    },

    watch: {
        reset: function () {
            if (this.reset) {
                this.resetFile();
            }
        },

        file: function () {
            this.$emit("select-file", this.file);
        }
    }
}