import Vue from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue';
// eslint-disable-next-line import/no-extraneous-dependencies
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import Layout from '@/layouts/Layout.vue';

createInertiaApp({
    resolve: (name) => resolvePageComponent(
        `./views/${name}.vue`,
        import.meta.glob('./views/**/*.vue'),
    ).then((module) => {
        // eslint-disable-next-line no-param-reassign
        module.default.layout = module.default.layout || Layout;
        return module;
    }),
    setup({
        el, App, props, plugin,
    }) {
        Vue.use(plugin);

        new Vue({
            render: (h) => h(App, props),
        }).$mount(el);
    },
});
