import Vue from 'vue'
import App from './App.vue'
import router from "./router"
import store from './store'
import VueMask from 'v-mask';

require("./api");
require("./filters/index");

Vue.use(VueMask);

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router,
  store
}).$mount('#dm-document')
