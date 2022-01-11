require('./bootstrap');

// integrar de vue en la ventana global
window.Vue = require('vue').default;

// importar bootstrap-vue
import { BootstrapVue } from 'bootstrap-vue';

// aplicar uso global de bootstrap-vue
Vue.use(BootstrapVue);