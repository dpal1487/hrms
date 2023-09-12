import('./bootstrap');
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Multiselect } from 'vue-multiselect';
// Import modules...
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import CKEditor from '@ckeditor/ckeditor5-vue';
import Vue3Toastify from 'vue3-toastify';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'REHNTU';

import "vue3-toastify/dist/index.css";

import Echo from "laravel-echo";

import io from 'socket.io-client';

window.io = io; // Make the Socket.io client available globally

window.echo = new Echo({
    broadcaster: "socket.io",
    host: window.location.hostname + ":6001",
    encrypted: true,
});


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    //
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue")),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(Multiselect)
            .use(plugin).use(CKEditor).use(Vue3Toastify, { autoClose: 3000, theme: "colored" })
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#ad3861' });
