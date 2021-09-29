<template>
  <div>      
      <div class="cols cols-50" >
        <h2>LISTA DE CERTIFICADOS</h2>
        <div class="align-right">
            <router-link :to="{ name: 'documento.new' }" class="button button-primary" >+ Novo documento</router-link>
        </div>
      </div>    
    <div class="cols cols-33 shortcode" >
      <div>
        <input type="text" v-model="search" placeholder="Filtrar" >
      </div>
      <div>
        <button type="submit" class="button button-secondary" @click.prevent="handlerSearch" >Pesquisar</button>
      </div>
    </div>
    <table class="wp-list-table widefat fixed striped table-view-list">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Categoria</th>
          <th>Descricao</th>
          <th>Shortcode</th>
        </tr>
      </thead>
      <tbody>
        <template v-if="items.length" >
          <tr v-for="(item, key) in items" :key="key" :class="{ draft: item.status == 'draft' }" >
            <td class="title column-title has-row-actions column-primary">
              <strong>
                <router-link
                  :to="{ name: 'documento.edit', params: { id: item.ID } }"
                  >{{ item.titulo }}</router-link
                >
              </strong>
              <div class="row-actions">
                <span class="edit">
                  <router-link :to="{ name: 'documento.edit', params: { id: item.ID } }" >
                      <span class="dashicons dashicons-edit" title="Editar" ></span>
                    </router-link> |
                </span>
                <span class="trash">
                    <a href="javaScript:void()" @click.prevent="handlerRemove(key, item)" ><span class="dashicons dashicons-trash" title="Remover" ></span></a> | </span>
                <span class="view">
                  <span v-if="item.status == 'draft'" class="dashicons dashicons-hidden" title="Rascunho" ></span>
                  <span v-else class="dashicons dashicons-visibility" title="Publicado" ></span>
                </span>                
              </div>
            </td>
            <td>
              <span v-html="getCatFullTitle(item.ID_category)"></span>
            </td>
            <td>{{ item.descricao }}</td>
            <td><input type="text" :value="`[dm_documentos doc='${item.ID}']`" readonly @click="(e) => copyShortcode(e)" /></td>
          </tr>
        </template>
        <template v-else-if="no_items" >
            <tr>
                <td colspan="4" class="align-center" >
                  Nenhum item encontrado
                </td>
            </tr>
        </template>
        <template v-else >
            <tr>
                <td colspan="4" class="align-center" >
                  <span class="spinner is-active"></span> Carregando...
                </td>
            </tr>
        </template>
      </tbody>
      <tfoot>
       <tr>
          <th>Nome</th>
          <th>Categoria</th>
          <th>Descricao</th>
          <th>Shortcode</th>
        </tr>
      </tfoot>
    </table>    
    <custom-paginate
      :page-count="total_pages"
      v-model="current_page"
      :click-handler="handlerClick"
     />
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import mixin from '../common-list-mixin';

export default {  
  computed: mapState('documentos',['items','current_page','total_pages','no_items', 'categories']),
  methods: mapActions('documentos',['getItems', 'removeItem']),    
  mixins: [
    mixin
  ]
};
</script>
