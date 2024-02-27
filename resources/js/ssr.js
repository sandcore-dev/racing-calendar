import { createInertiaApp } from '@inertiajs/vue2';
import createServer from '@inertiajs/vue2/server';
import Vue from 'vue';
// eslint-disable-next-line import/no-extraneous-dependencies
import { createRenderer } from 'vue-server-renderer';
// eslint-disable-next-line import/no-extraneous-dependencies
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Layout from '@/layouts/Layout.vue';

createServer((page) => createInertiaApp({
    page,
    render: createRenderer().renderToString,
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

        return new Vue({
            render: (h) => h(App, props),
        }).$mount(el);
    },
}));
