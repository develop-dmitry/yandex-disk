import Axios from "axios";

export default class Ajax {
    async post(url, params) {
        let result = await Axios.post(url, params);
        return result.data;
    }

    async get(url, params) {
        let result = await Axios.get(url, params);
        return result.data;
    }
}