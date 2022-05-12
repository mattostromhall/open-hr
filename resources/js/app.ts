import Main from '@/Layouts/Main.vue'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name => {
        const page = require(`./Pages/${name}`).default
        if (page.layout === undefined) {
            page.layout = Main
        }
        return page
    },
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .mount(el)
    },
})

InertiaProgress.init({ color: '#4B5563' })
