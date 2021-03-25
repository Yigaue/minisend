require('./bootstrap');
import Vue from 'vue';

import router from './routes';

import store from './store'

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
    router,
    store,

    created () {
        const user = localStorage.getItem('user')
        if (user) {
          const userData = JSON.parse(user)
          this.$store.commit('setAccessToken', userData)
        }
        axios.interceptors.response.use(
          response => response,
        )
      },
});
