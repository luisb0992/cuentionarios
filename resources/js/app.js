require('./bootstrap');

// integrar de vue en la ventana global
window.Vue = require('vue').default;

// importar bootstrap-vue
import { BootstrapVue } from 'bootstrap-vue';

// vuej toast (notificaciones)
import VueToast from 'vue-toast-notification';

// importar vue-loading-overlay
import Loading from 'vue-loading-overlay';

//import el tema y uso global de Vuetoast
// por default 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';

// Import estilos de vue-loading-overlay
import 'vue-loading-overlay/dist/vue-loading.css';

// aplicar usos globales
Vue.use(BootstrapVue);
Vue.use(VueToast);
Vue.use(Loading);
