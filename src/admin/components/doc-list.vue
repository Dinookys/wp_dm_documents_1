<template>
    <div>
        <button class="button button-primary" @click.prevent="clickUpload" >
            <span v-html="textButtonUpload" ></span>
        </button>
        <ul v-if="docs.length" class="list-docs" >
            <li v-for="(doc, key) in docs" :key="key" >
                <div class="cols cols-75-25">                    
                    <div>
                        <h3>Nome: <b>{{doc.name}}</b></h3>                       
                        <span>Tamanho: <b>{{doc.filesize}}</b></span><br>
                        <span>Tipo: <b>{{doc.subtype}}</b></span><br>                            
                    </div>
                    <div class="align-right" >
                        <p><a :href="doc.url" class="button button-primary" target="_blank" >Ver arquivo</a></p>
                        <p><button class="button button-default" @click="handlerRemove(key)" >Remover</button></p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        clickUpload: {
            type: Function,
            default: () => {}
        },
        textButtonUpload: {
            type: String,
            default: 'Upload'
        },
        docs: {
            type: Array,
            default() {
                return []
            }
        }
    },
    methods: {
        handlerRemove(key) {
            // console.log(key);
            this.$emit('onRemove', key);
        }
    }
}
</script>