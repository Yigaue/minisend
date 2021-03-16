require('./bootstrap');
// import Vue from 'vue';

import router from './routes';

import {BootstrapVue, IconsPlugin} from 'bootstrap-vue';

window.Vue = require('vue');

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import EmailsComponent from './components/EmailsComponent.vue';
import EmailComponent from './components/EmailsComponent.vue';
import CreateEmailComponent from './components/CreateEmailComponent.vue';
import PassportClients from './components/passport/PassportClients.vue';
import AuthorizedClients from './components/passport/AuthorizedClients.vue';
import PersonalAccessTokens from './components/passport/PersonalAccessTokens.vue';

const app = new Vue({
    el: '#app',
    components: {
        EmailsComponent,
        EmailComponent,
        CreateEmailComponent,
        AuthorizedClients,
        PersonalAccessTokens,
        PassportClients
    },

    router
});
