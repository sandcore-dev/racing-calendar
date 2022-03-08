import Vue from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue';
import 'bootstrap';

createInertiaApp({
    // eslint-disable-next-line import/no-dynamic-require,global-require
    resolve: (name) => require(`./views/${name}`),
    setup({
        el, App, props, plugin,
    }) {
        Vue.use(plugin);

        new Vue({
            render: (h) => h(App, props),
        }).$mount(el);
    },
});
