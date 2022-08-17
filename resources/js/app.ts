import Main from '@/Layouts/Main.vue'
import {createApp, h} from 'vue'
import type {DefineComponent} from 'vue'
import {createInertiaApp} from '@inertiajs/inertia-vue3'
import {InertiaProgress} from '@inertiajs/progress'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers'
import '../css/app.css'

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
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .mount(el)
    },
})

InertiaProgress.init({ color: '#4B5563' })
