import('./bootstrap');
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";
import { Multiselect } from 'vue-multiselect'

// Import modules...
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

import Vue3Toastify from 'vue3-toastify';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

import "vue3-toastify/dist/index.css";
import VueClipboard from 'vue3-clipboard';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    //
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue")),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(Multiselect).use(VueClipboard,{
            autoSetContainer: true,
            appendToBody: true,
            })
            .use(plugin).use(Vue3Toastify, {autoClose: 3000,})
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
