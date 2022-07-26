import Vue from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue';

import Layout from '@/layouts/Layout.vue';

createInertiaApp({
    resolve: (name) => {
        // eslint-disable-next-line import/no-dynamic-require,global-require
        const page = require(`./views/${name}`).default;
        page.layout = page.layout || Layout;
        return page;
    },
    setup({
        el, App, props, plugin,
    }) {
        Vue.use(plugin);

        new Vue({
            render: (h) => h(App, props),
        }).$mount(el);
    },
});
