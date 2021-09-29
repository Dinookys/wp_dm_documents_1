<template>
  <div>
    <notification-alert :messages="messages" :validations="validationsErrors" />
    <div class="cols cols-50">
        <div v-if="isEdit" >
            <h2>EDITANDO CATEGORIA</h2>
        </div>
        <div v-else >
            <h2>NOVA CATEGORIA</h2>
        </div>
        <div class="align-right">
            <span class="spinner is-active save" v-if="saving" ></span>
            <button class="button button-primary" @click.prevent="saveItem(item)" >Salvar</button>
        </div>    
    </div>
    <div class="cols cols-100" >        
        <div>
            <label>
                Título<br>
                <input type="text" class="form-control" placeholder="Nome" v-model="item.titulo" >
            </label>
        </div>
        <div>
            <label>
                Descriçao<br>
                <textarea type="text" class="form-control" placeholder="Descrição" v-model="item.descricao"></textarea>
            </label>
        </div>
    </div>
    <div class="cols cols-100" >
        <div>
            <label>
                Categoria Pai<br>
                <select v-model="item.ID_parent" >
                    <option value="0">Raiz</option>
                    <option v-for="(cat, k) in cats" :key="k" :value="cat.ID" v-html="cat.titulo" ></option>
                </select>
            </label>
        </div>    
        <div>
            <label>
                Publicado?<br>
                <select v-model="item.status">                    
                    <option v-for="(name, value) in status" :key="value" :value="value" >{{ name }}</option>                    
                </select>
            </label>
        </div>
    </div>    
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';

// Mixin
import mixin from './../common-item-mixin';

export default {    
    computed: {
        ...mapState('categorias', ['validationsErrors','messages','item','categories','status','datePickerConf', 'saving']),
        cats() {
            return this.categories.filter((cat) => cat.ID != this.item.ID);
        }
    },
    methods: mapActions('categorias', ['getItem','newEmptyItem','destroyItem', 'clearMessages', 'saveItem']),    
    mixins: [
        mixin
    ]    
}
</script>