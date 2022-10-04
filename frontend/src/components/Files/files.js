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
}