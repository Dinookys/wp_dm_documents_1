import Vue from "vue";
import axios from "axios";

axios.defaults.baseURL = window.dm_documents.restAPI;
// Add a request interceptor
axios.interceptors.request.use(function (config) {
    config.headers['X-WP-Nonce'] =  window.dm_documents.token;

    return config;
});

Vue.prototype.http = axios;