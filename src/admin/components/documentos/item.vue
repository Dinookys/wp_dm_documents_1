<template>
  <div>
    <notification-alert :messages="messages" :validations="validationsErrors" />
    <div class="cols cols-50">
        <div v-if="isEdit" >
            <h2>EDITANDO DOCUMENTO</h2>
        </div>
        <div v-else >
            <h2>NOVO DOCUMENTO</h2>
        </div>
        <div class="align-right">
            <span class="spinner is-active save" v-if="saving" ></span>
            <button class="button button-primary" @click.prevent="saveItem(item)" >Salvar</button>
        </div>    
    </div>
    <div class="cols cols-50" >
        <div>
            <label>
                Nome<br>
                <input type="text" class="form-control" placeholder="Nome" v-model="item.titulo" >
            </label>
        </div>        
        <div>
            <label>
                Categoria<br>
                <select id="categoria" v-model="item.ID_category" >
                    <option value="">--Selecione uma categoria--</option>
                    <option v-for="(cat, k) in categories" :key="k" :value="cat.ID" v-html="cat.titulo" ></option>
                </select>
            </label>
        </div>
    </div>
    <div class="cols cols-50" >
        <div>
            <label>
                Data de Publicação<br>
                <!-- <input type="text" placeholder="Data de abertura" v-model="item.data_abertura" > -->
                <date-picker :lang="ptBr" :value-type="datePickerConf.format" :format="datePickerConf.format" v-model="item.data" ></date-picker>
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
    <div class="cols cols-100" >
        <div>
            <label>
                Descrição<br>
                <textarea class="form-control" placeholder="Descrição" v-model="item.descricao" ></textarea>
            </label>
        </div>             
    </div>
    <br>
    <div class="cols cols-50 border background-white">
        <div class="border-right" >
            <h4 class="align-center border-bottom padding-bottom" >Documentos</h4>
            <doc-list 
                v-if="item.documentos"
                :docs="item.documentos.interno"
                :clickUpload="handlerUpload"
                @onRemove="(key) => handlerRemove(key, 'interno')"
            ></doc-list>
        </div>
        <div>
            <h4 class="align-center border-bottom padding-bottom" >Documentos externos ( LINKS )</h4>
            <doc-list 
                v-if="item.documentos"
                :docs="item.documentos.externo"
                :clickUpload="() => hanlder_external = true"
                textButtonUpload="Novo link"
                @onRemove="(key) => handlerRemove(key, 'externo')"
            ></doc-list>
        </div>
    </div>

    <div :class="`mediamodal border wp-core-ui ${hanlder_external ? 'block' : ''}`" >
        <a class="media-modal-close" @click.prevent="() => hanlder_external = false" >
            <span class="media-modal-icon"></span>
        </a>
        <div class="cols cols-100">
            <div>
                <label>
                    <input type="text" placeholder="Nome do documento" v-model="doc_externo.name" >
                </label>
            </div>
            <div>
                <label>
                    <input type="text" placeholder="URL" v-model="doc_externo.url" >
                </label>
            </div>            
        </div>
        <div class="cols cols-50">
            <div>
                <label>
                    <input type="text" placeholder="Tipo: zip, rar, pdf, doc" v-model="doc_externo.subtype" >
                </label>
            </div>
            <div>
                <label>
                    <input type="text" placeholder="Tamanho: 1mb, 20kb" v-model="doc_externo.filesize" >
                </label>
            </div>
        </div>
        <button class="button button-secondary save" @click="handlerExternal">Salvar</button>
    </div>
    <a class="backdrop" @click.prevent="() => hanlder_external = false" ></a>

  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';

// Mixin
import mixin from './../common-item-mixin';

//Components
import docList from '../doc-list';
import datePicker from 'vue2-datepicker';

export default {    
    data() {
        return {
            hanlder_external: false,
            doc_externo: {
                name: '',
                url: '',
                filesize: ''
            }
        }
    },
    computed: mapState('documentos', ['validationsErrors','messages','item','categories','status','datePickerConf', 'saving']),
    methods: {
        handlerExternal() {
            this.item.documentos.externo = [
                {...this.doc_externo},
                ...this.item.documentos.externo
            ];

            this.hanlder_external = false;

            this.doc_externo = {
                name: '',
                url: '',
                filesize: '',
                subtype: '',
            }
        },
        handlerUpload() {
            var custom_uploader = window.wp.media({
                title: 'Novo documento',
                library : {
                    // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                    // type : 'image'
                },
                button: {
                    text: 'Adicionar' // button label text
                },
                multiple: false
            }).on('select', () => { // it also has "open" and "close" events
                var attachment = custom_uploader.state().get('selection').first().toJSON();  
                                
                // console.log(attachment);
                let old = this.item.documentos.interno || [];

                // console.log(attachment);
                
                this.item.documentos.interno = [...old, {
                    url: attachment.url,
                    name: attachment.title,
                    filesize: attachment.filesizeHumanReadable,                    
                    subtype: attachment.subtype,        
                }];
            }).open();
        },
        handlerRemove(key, destinate) {
            let docs = [...this.item.documentos[destinate]]
            docs.splice(key,1);
            this.item.documentos[destinate] = [...docs]
        },
        ...mapActions('documentos', ['getItem','newEmptyItem','destroyItem', 'clearMessages', 'saveItem', 'updateCategories'])
    },    
    mixins: [
        mixin
    ],
    mounted() {
        this.updateCategories();
    },
    components: {
        docList,
        datePicker
    }
}
</script>

<style scoped>
    .mediamodal {
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        display: none;
        width: 800px;
        max-width: 90%;
        background-color: white;
        padding: 50px 10px;
    }

    .mediamodal.block {
        display: block;
    }

    .mediamodal.block ~ .backdrop {
        position: fixed;
        z-index: 9998;
        left: 0;
        top: 0;
        bottom: 0;
        right: 0;
        background-color: rgba(0, 0, 0, .7);
    }

    .media-modal-close {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mediamodal .save {
        position: absolute;
        right: 10px;
        bottom: 10px;
    }

</style>