require('./bootstrap');
import Vue from 'vue';

import router from './routes';

import {BootstrapVue, IconsPlugin} from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import EmailsComponent from './components/EmailsComponent';
import EmailComponent from './components/EmailsComponent';
import CreateEmailComponent from './components/CreateEmailComponent';
const app = new Vue({
    el: '#app',
    components: {
        EmailsComponent,
        EmailComponent,
        CreateEmailComponent
    },
    router
});
