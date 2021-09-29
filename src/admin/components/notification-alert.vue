<template>
  <div>
    <div :class="'notice ' + message_type" v-show="has_messages" >{{ first_message }}</div>
    <div class="notice notice-error" v-show="has_validations" >
        <p v-for="(message, key) in validation_messsages" :key="key" >{{ message }}</p>
    </div>
  </div>
</template>

<script>
export default {
    props: {
        messages: {
            type: Object,
            default() {
                return {}
            }
        },
        validations: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    computed: {
        has_messages() {
            return Object.keys(this.messages).length > 0;
        },
        has_validations() {
            return Object.keys(this.validations).length > 0;
        },
        validation_messsages() {
            if(this.has_validations) {
                let messages = [];
                Object.keys(this.validations).map((key) => messages.push(this.validations[key][0]));

                return messages;
            }
            return [];
        },
        first_message() {
            if(Object.keys(this.messages).length > 0) {
                let key = Object.keys(this.messages)[0];
                return this.messages[key];
            }
            return '';
        },
        message_type() {
            if(Object.keys(this.messages).length > 0) {
                return Object.keys(this.messages)[0].replace('_', '-');
            }
            return '';
        }
    }
    
}
</script>

<style>

</style>