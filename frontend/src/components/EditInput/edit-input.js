export default {
    name: "EditInput",
    data: () => {
        return {
            currentValue: "",
            isEdit: false
        }
    },
    emits: [
        "submit"
    ],
    props: {
        value: {
            type: String
        },
        fileIndex: {
            type: Number,
            required: true
        },
        reset: {
            type: Boolean
        }
    },
    methods: {
        submit() {
            this.isEdit = false;
            if (this.value !== this.currentValue) {
                this.$emit("submit", {
                    index: this.fileIndex,
                    value: this.currentValue
                });
            }
        },

        edit() {
            this.currentValue = this.value;
            this.isEdit = true;
        }
    },
    watch: {
        value: function () {
            this.currentValue = this.value;
        },
    },
    created() {
        this.currentValue = this.value;
    }
}