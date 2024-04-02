import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import vuetify from './Plugins/vuetify'
import toast from './Plugins/toast'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => {
    const page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))
    page.then((module) => {
      module.default.layout = module.default.layout || AuthenticatedLayout
    })
    return page
  },
  setup({ el, App, props, plugin }) {
    let myApp = createApp({ render: () => h(App, props) })
    myApp.use(plugin)
    myApp.use(vuetify)
    myApp.use(toast)
    // eslint-disable-next-line no-undef
    myApp.use(ZiggyVue, Ziggy)
    return myApp.mount(el)
  },
  progress: {
    color: '#4CAF50',
  },
})
