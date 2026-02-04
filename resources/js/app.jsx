import './bootstrap';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';

createInertiaApp({
    title: (title) => `${title} - Rouf AI LMS`,
    resolve: async (name) => {
        const pages = import.meta.glob('./Pages/**/*.jsx');
        return await pages[`./Pages/${name}.jsx`]();
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
    progress: {
        color: '#e850ff',
    },
});
