import ptBr from 'vue2-datepicker/locale/pt-br'
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

import NotificationAlert from './notification-alert.vue';

export default {
    data() {
        return {
            ptBr
        }
    },
    computed: {
        isEdit() {
            return this.$route.params.id !== undefined;
        },
    },    
    mounted() {
        if(this.isEdit) {
            this.getItem(this.$route.params.id);
        } else {
            this.newEmptyItem();
        }
    },
    beforeDestroy() {
        this.destroyItem()
        this.clearMessages()
    },
    components: {
        NotificationAlert,
        DatePicker
    },
}