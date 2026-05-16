<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChatbotResponse;

class ChatbotResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $responses = [
            // ESPAÑOL
            ['keyword' => 'cursos', 'language' => 'es', 'response' => '📚 Los cursos disponibles en EcoLearn incluyen:\n\n🌿 Sostenibilidad y Desarrollo Sostenible\n♻️ Reciclaje y Gestión de Residuos\n🌱 Educación Ambiental\n🌍 Cambio Climático\n💧 Conservación del Agua\n\n¿Deseas inscribirte en alguno?', 'priority' => 10, 'category' => 'courses'],
            ['keyword' => 'tareas', 'language' => 'es', 'response' => '✅ Puedes ver todas tus tareas en la sección "Tareas" del panel de control.\n\nCada tarea incluye:\n- Descripción detallada\n- Fecha de entrega\n- Puntuación máxima\n- Archivo de referencia\n\n¿Necesitas ayuda con alguna tarea específica?', 'priority' => 10, 'category' => 'tasks'],
            ['keyword' => 'evaluaciones', 'language' => 'es', 'response' => '📝 Las evaluaciones en EcoLearn te ayudan a medir tu progreso.\n\nTipos de evaluaciones:\n✏️ Cuestionarios teóricos\n🔬 Análisis prácticos\n📊 Proyectos ambientales\n\nAccede desde "Mis Evaluaciones" en tu panel.', 'priority' => 10, 'category' => 'evaluations'],
            ['keyword' => 'sostenibilidad', 'language' => 'es', 'response' => '🌱 La sostenibilidad es el corazón de EcoLearn.\n\nNuestro enfoque incluye:\n🌍 Responsabilidad ambiental\n♻️ Economía circular\n🤝 Responsabilidad social\n🔋 Energías renovables\n\n¿Quieres aprender más sobre algún aspecto?', 'priority' => 10, 'category' => 'sustainability'],
            ['keyword' => 'ayuda', 'language' => 'es', 'response' => '🆘 ¡Claro que sí! Aquí hay áreas donde puedo ayudarte:\n\n- Información sobre cursos\n- Detalles de tareas\n- Consejos de evaluaciones\n- Temas de sostenibilidad\n- Preguntas generales\n\n¿Sobre qué necesitas asistencia?', 'priority' => 9, 'category' => 'help'],
            ['keyword' => 'login', 'language' => 'es', 'response' => '🔐 Para iniciar sesión:\n\n1. Ve a la página de inicio\n2. Haz clic en "Iniciar sesión"\n3. Ingresa tu correo y contraseña\n4. ¡Acceso completado!\n\n¿Olvidaste tu contraseña? Usa la opción "Recuperar contraseña".', 'priority' => 8, 'category' => 'account'],
            ['keyword' => 'registro', 'language' => 'es', 'response' => '📝 Proceso de registro:\n\n1. Haz clic en "Crear cuenta"\n2. Completa tu información personal\n3. Elige una contraseña segura\n4. Verifica tu correo\n5. ¡Comienza a aprender!\n\n¿Tienes dudas en el registro?', 'priority' => 8, 'category' => 'account'],
            ['keyword' => 'ambiente', 'language' => 'es', 'response' => '🌍 La educación ambiental es fundamental.\n\nEn EcoLearn nos enfocamos en:\n🌿 Biodiversidad\n🌊 Conservación hídrica\n🌤️ Calidad del aire\n🏔️ Ecosistemas\n\n¿Qué aspecto ambiental te interesa?', 'priority' => 9, 'category' => 'environment'],
            ['keyword' => 'progreso', 'language' => 'es', 'response' => '📊 Puedes ver tu progreso en:\n\n✅ Panel de control - Resumen general\n📈 Estadísticas - Desempeño por curso\n🎯 Objetivos - Metas alcanzadas\n📜 Certificados - Logros completados\n\n¿Quieres conocer tus logros específicos?', 'priority' => 8, 'category' => 'progress'],

            // ENGLISH
            ['keyword' => 'courses', 'language' => 'en', 'response' => '📚 Available courses on EcoLearn include:\n\n🌿 Sustainability and Sustainable Development\n♻️ Recycling and Waste Management\n🌱 Environmental Education\n🌍 Climate Change\n💧 Water Conservation\n\nWould you like to enroll in any?', 'priority' => 10, 'category' => 'courses'],
            ['keyword' => 'tasks', 'language' => 'en', 'response' => '✅ You can view all your tasks in the "Tasks" section of your dashboard.\n\nEach task includes:\n- Detailed description\n- Delivery date\n- Maximum score\n- Reference files\n\nDo you need help with a specific task?', 'priority' => 10, 'category' => 'tasks'],
            ['keyword' => 'evaluations', 'language' => 'en', 'response' => '📝 Evaluations on EcoLearn help you measure your progress.\n\nTypes of evaluations:\n✏️ Theoretical quizzes\n🔬 Practical analyses\n📊 Environmental projects\n\nAccess them from "My Evaluations" in your dashboard.', 'priority' => 10, 'category' => 'evaluations'],
            ['keyword' => 'sustainability', 'language' => 'en', 'response' => '🌱 Sustainability is the heart of EcoLearn.\n\nOur approach includes:\n🌍 Environmental responsibility\n♻️ Circular economy\n🤝 Social responsibility\n🔋 Renewable energy\n\nWould you like to learn more about any aspect?', 'priority' => 10, 'category' => 'sustainability'],
            ['keyword' => 'help', 'language' => 'en', 'response' => '🆘 Of course! Here are areas where I can help:\n\n- Course information\n- Task details\n- Evaluation tips\n- Sustainability topics\n- General questions\n\nWhat do you need assistance with?', 'priority' => 9, 'category' => 'help'],
            ['keyword' => 'login', 'language' => 'en', 'response' => '🔐 To log in:\n\n1. Go to the home page\n2. Click "Log in"\n3. Enter your email and password\n4. Access granted!\n\nForgot your password? Use "Recover password" option.', 'priority' => 8, 'category' => 'account'],
            ['keyword' => 'register', 'language' => 'en', 'response' => '📝 Registration process:\n\n1. Click "Create account"\n2. Complete your personal information\n3. Choose a strong password\n4. Verify your email\n5. Start learning!\n\nHave questions about registration?', 'priority' => 8, 'category' => 'account'],
            ['keyword' => 'environment', 'language' => 'en', 'response' => '🌍 Environmental education is fundamental.\n\nAt EcoLearn we focus on:\n🌿 Biodiversity\n🌊 Water conservation\n🌤️ Air quality\n🏔️ Ecosystems\n\nWhich environmental aspect interests you?', 'priority' => 9, 'category' => 'environment'],
            ['keyword' => 'progress', 'language' => 'en', 'response' => '📊 You can view your progress in:\n\n✅ Dashboard - General overview\n📈 Statistics - Performance by course\n🎯 Goals - Milestones achieved\n📜 Certificates - Completed achievements\n\nWould you like to know your specific accomplishments?', 'priority' => 8, 'category' => 'progress'],
        ];

        foreach ($responses as $response) {
            ChatbotResponse::updateOrCreate(
                ['keyword' => $response['keyword'], 'language' => $response['language']],
                $response
            );
        }
    }
}
