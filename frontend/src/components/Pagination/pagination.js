export default {
    name: "Pagination",

    props: {
        pages: Number,
        currentPage: Number
    },

    emits: [
        "select-page"
    ]
}