import {createApp} from "vue";
import {createPinia} from "pinia";
import App from "./components/App/App.vue";
import "normalize.css";

const app = createApp(App).use(createPinia()).mount("#app");