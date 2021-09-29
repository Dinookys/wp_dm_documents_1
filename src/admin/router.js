import Vue from "vue";
import VueRouter from "vue-router";

import documentos from './components/documentos';
import documento from './components/documentos/item';

import categorias from './components/categorias';
import categoria from './components/categorias/item';

Vue.use(VueRouter);

const routes = [
    { path: "/", redirect: "/documentos"},

    { path: "/documentos/new", component: documento, name: 'documento.new'},
    { path: "/documentos/:id/edit", component: documento, name: 'documento.edit'},
    { path: "/documentos/:page?", component: documentos, name: 'documentos'},
    
    { path: "/categorias/new", component: categoria, name: 'categoria.new'},
    { path: "/categorias/:id/edit", component: categoria, name: 'categoria.edit'},
    { path: "/categorias/:page?", component: categorias, name: 'categorias'},
];

const router = new VueRouter({
    routes,
    linkActiveClass: 'active',
    linkExactActiveClass: 'active'
});

export default router

