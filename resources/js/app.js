import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import axios from 'axios';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        // ✅ Apply user theme color before mounting
        axios.get('/api/user/theme-color').then(res => {
            const themeMap = {
                blue: '#3b82f6',
                emerald: '#10b981',
                rose: '#f43f5e',
                amber: '#f59e0b',
                violet: '#8b5cf6',
                indigo: '#6366f1',
            }
            document.documentElement.style.setProperty('--primary-color', themeMap[res.data.theme_color])
        }).finally(() => {
            // Mount the app after applying theme
            createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue)
                .mount(el);
        })

        // Don't mount immediately — wait for .then/.finally
        return null;
    },
    progress: {
        color: '#4B5563',
    },
});
