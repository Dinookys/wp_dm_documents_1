import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

//Modules
import documentos from "./../components/documentos/store";
import categorias from "./../components/categorias/store";

export default new Vuex.Store({
    modules: {
        documentos,
        categorias,
    }
});