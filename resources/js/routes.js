import Vue from 'vue';
import VueRouter from 'vue-router';

import EmailsComponent from './components/EmailsComponent.vue';

import EmailComponent from './components/EmailComponent.vue';

import CreateEmailComponent from './components/CreateEmailComponent.vue';

import vueRouter from 'vue-router';

Vue.use(vueRouter);

const routes = [
    {
        path: '',
        component: EmailsComponent,
        name: 'Emails',
        props: true
    },

    {
        path: '/api/emails/:id',
        component: EmailComponent,
        name: 'Email',
        props: true,
    },

    {
        path: '/emails/create',
        component: CreateEmailComponent,
        name: 'Create',
        props: true
    },
];

export default new VueRouter({
    routes: routes,
    mode: 'history'
})
