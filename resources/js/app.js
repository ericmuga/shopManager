import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import PrimeVue from 'primevue/config';

//theme
import "primevue/resources/themes/lara-light-indigo/theme.css";
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import MultiSelect from 'primevue/multiselect';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import Pagination from '@/Components/Pagination.vue'
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import Tooltip from 'primevue/tooltip';
import Checkbox from 'primevue/checkbox';
import ConfirmPopup from 'primevue/confirmpopup';
import ConfirmationService from 'primevue/confirmationservice';
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import Swal from 'sweetalert2';
import SearchBox from '@/Components/SearchBox.vue'
import Drop from '@/Components/Drop.vue'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue)
            .use(ZiggyVue, Ziggy)
            .component('ToolBar',Toolbar)
            .component('Checkbox',Checkbox)
            .component('Button',Button)
            .component('InputText',InputText)
            .component('InputNumber',InputNumber)
            .directive('Tooltip',Tooltip)
            .component('MultiSelect',MultiSelect)
            .component('Dropdown',Dropdown)
            .component('Pagination',Pagination)
            .component('SearchBox',SearchBox)
            .component('Drop',Drop)
            .component('Calendar',Calendar)
            .component('Swal',Swal)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
