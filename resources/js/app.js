import './bootstrap';
import 'bootstrap/dist/css/bootstrap.css';
import { createApp } from 'vue';
import { router } from './router';
import store from './store';
import appMain from './app.vue';

const app = createApp(appMain);
app.use(store);
app.use(router);
app.mount("#app");