import FileTable from "../FileTable/FileTable.vue";
import FileForm from "../FileForm/FileForm.vue";
import Pagination from "../Pagination/Pagination.vue";
import Loader from "../Loader/Loader.vue";
import {useFilesStore} from "../Stores/files-store";

export default {
    name: "Files",

    components: {
        FileTable,
        FileForm,
        Pagination,
        Loader
    },

    setup() {
        const filesStore = useFilesStore();

        return { filesStore }
    },

    methods: {
        async selectPage(page) {
            this.filesStore.setLoading(true);

            await this.filesStore.changePage(page);

            this.filesStore.setLoading(false);
        }
    }
}