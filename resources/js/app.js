import './bootstrap';
import { createApp } from 'vue';
import Chatbot from './components/Chatbot.vue';

document.addEventListener('DOMContentLoaded', () => {
    // Crear app con el componente Chatbot como raíz
    const app = createApp(Chatbot);
    
    // Si existe un elemento #app, montarse allí
    const appElement = document.getElementById('app');
    if (appElement) {
        app.mount(appElement);
    } else {
        // Si no existe, crear un contenedor y montarse en el body
        const container = document.createElement('div');
        container.id = 'chatbot-app';
        document.body.appendChild(container);
        app.mount(container);
    }
});
