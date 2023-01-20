import Main from '@/Layouts/Main.vue'
import {createApp, h} from 'vue'
import type {DefineComponent} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers'
import '../css/App.css'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))
        .then(page => {
            // @ts-ignore
            if (page.default.layout === undefined) {
                // @ts-ignore
                page.default.layout = Main
            }
            return page as Promise<DefineComponent>
        }),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
    progress: { color: '#4B5563' }
})
