import './bootstrap';
import { createApp } from 'vue';
import HomePage from './Components/HomePage.vue';

const app = createApp({});
app.component('home-page', HomePage);
app.mount('#app');