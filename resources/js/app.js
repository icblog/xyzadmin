import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";

//Using dynamic import for production
// createInertiaApp({
//     resolve: async (name) => (await import(`./pages/${name}.vue`)),
//     setup({ el, App, props, plugin }) {
//         createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .mount(el);
//     },

// });


createInertiaApp({
    resolve: (name) => require(`./pages/${name}.vue`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },

});
