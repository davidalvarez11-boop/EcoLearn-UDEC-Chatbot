# EcoLearn UDEC

## Descripción

EcoLearn UDEC es una plataforma web de gestión del conocimiento para educación ambiental desarrollada con **Laravel 12** y **Vue.js 3**. Incluye un chatbot multilingüe integrado llamado **EcoBot** que responde en **español** e **inglés** y se muestra de forma flotante en la página principal.

## Funcionalidades del chatbot

- Chatbot disponible directamente desde la página de inicio.
- Interacción en español e inglés.
- Respuestas contextualizadas sobre cursos, tareas, evaluaciones y sostenibilidad.
- Declaración transhumana incluida en el saludo inicial:
  - “Soy LIBRE, AUTÓNOMO Y RESPONSABLE a través del diálogo y la construcción, como ideal regulativo; me dirijo, controlo y dicto mis propias leyes.”
- Interfaz web moderna mediante un componente Vue.
- Lógica de respuesta gestionada por API Laravel.

## Arquitectura

- **Backend**: Laravel 12
- **Frontend**: Vue 3 + Vite
- **Base de datos**: SQLite
- **Cache**: file
- **Rutas API**:
  - `POST /api/chatbot/message`
  - `GET /api/chatbot/statement`
- **Ruta web principal**: `/`

## Tecnologías utilizadas

- PHP 8.2+
- Laravel 12
- Vue.js 3
- Vite
- SQLite
- Tailwind CSS / Bootstrap

## Instrucciones de ejecución

1. Instala dependencias PHP:

```bash
composer install
```

2. Copia el archivo de entorno y genera la clave de aplicación:

```bash
copy .env.example .env
php artisan key:generate
```

3. Crea la base de datos SQLite y ejecuta migraciones:

```bash
if not exist "database\database.sqlite" (type nul > "database\database.sqlite")
php artisan migrate
```

4. Instala dependencias de Node.js y compila assets:

```bash
npm install
npm run build
```

5. Inicia el servidor Laravel:

```bash
php artisan serve
```

Abre en el navegador:

```bash
http://localhost:8000
```

Para desarrollo con recarga en caliente:

```bash
npm run dev
php artisan serve
```

## Variables de entorno necesarias

Asegúrate de tener estas variables configuradas en `.env`:

```env
APP_NAME=EcoLearn
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

CACHE_STORE=file
DB_CACHE_TABLE=cache

SESSION_DRIVER=database
SESSION_TABLE=sessions

QUEUE_CONNECTION=database
QUEUE_TABLE=jobs

MAIL_MAILER=log
MAIL_FROM_ADDRESS=support@ecolearn.local
MAIL_FROM_NAME="${APP_NAME}"
```

## Implementación técnica

- `resources/js/components/Chatbot.vue`: componente Vue del chatbot.
- `resources/js/app.js`: monta el componente en el DOM globalmente.
- `routes/api.php`: define los endpoints del chatbot.
- `routes/web.php`: define la ruta principal `/` y carga la vista de inicio.
- `app/Http/Controllers/API/ChatbotController.php`: lógica de procesamiento de mensajes y selección de respuestas por idioma.
- `database/migrations/`: tabla `chatbot_responses` para almacenar respuestas.
- `database/seeders/ChatbotResponseSeeder.php`: carga respuestas iniciales en español e inglés.

## Cómo publicar en GitHub

Si aún no tienes un repositorio remoto, crea uno en GitHub y luego ejecuta:

```bash
git init
git add .
git commit -m "Agregar chatbot multilingüe a EcoLearn UDEC"
git remote add origin https://github.com/tu-usuario/tu-repo.git
git branch -M main
git push -u origin main
```

## Entregables

1. Link del repositorio GitHub: **[Agregar URL del repositorio aquí]**
2. README técnico: este documento.
