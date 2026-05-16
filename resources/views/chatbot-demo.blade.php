<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoBot - Chatbot Multilingüe</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #667eea;
            margin-bottom: 10px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .feature {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .feature h3 {
            color: #667eea;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .feature p {
            color: #666;
            font-size: 13px;
            line-height: 1.5;
        }

        .tech-stack {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .tech-stack h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .tech-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .tech-item {
            display: flex;
            align-items: center;
            color: #555;
            font-size: 13px;
        }

        .tech-item:before {
            content: "✓";
            color: #667eea;
            font-weight: bold;
            margin-right: 8px;
        }

        .statement {
            background: #fff2f2;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #f53003;
            margin-bottom: 30px;
        }

        .statement h3 {
            color: #f53003;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .statement p {
            color: #333;
            font-size: 13px;
            line-height: 1.6;
            font-style: italic;
        }

        .cta-section {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            color: white;
        }

        .cta-section h3 {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .cta-section p {
            font-size: 13px;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .cta-button {
            display: inline-block;
            background: white;
            color: #667eea;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .tech-list {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🤖 EcoBot Multilingüe</h1>
        <p class="subtitle">Asistente Inteligente para EcoLearn UDEC</p>

        <div class="features">
            <div class="feature">
                <h3>💬 Conversación Natural</h3>
                <p>Interactúa de forma natural en español e inglés</p>
            </div>
            <div class="feature">
                <h3>🌐 Multilingüe</h3>
                <p>Español 🇪🇸 e Inglés 🇬🇧 totalmente soportados</p>
            </div>
            <div class="feature">
                <h3>📚 Educativo</h3>
                <p>Respuestas sobre cursos, tareas y evaluaciones</p>
            </div>
            <div class="feature">
                <h3>♻️ Sostenible</h3>
                <p>Enfocado en educación ambiental y sostenibilidad</p>
            </div>
        </div>

        <div class="tech-stack">
            <h3>🛠️ Stack Tecnológico</h3>
            <div class="tech-list">
                <div class="tech-item">Laravel 12</div>
                <div class="tech-item">Vue.js 3</div>
                <div class="tech-item">PHP 8.2+</div>
                <div class="tech-item">SQLite</div>
                <div class="tech-item">API REST</div>
                <div class="tech-item">Vite</div>
            </div>
        </div>

        <div class="statement">
            <h3>📌 Declaración Transhumana</h3>
            <p>"Soy LIBRE, AUTÓNOMO Y RESPONSABLE a través del diálogo y la construcción, como ideal regulativo; me dirijo, controlo y dicto mis propias leyes."</p>
        </div>

        <div class="cta-section">
            <h3>¡Prueba EcoBot Ahora!</h3>
            <p>Haz clic en el botón de chat en la esquina inferior derecha</p>
            <p style="font-size: 24px; margin-top: 10px;">💬</p>
        </div>
    </div>

    <!-- Cargar Vue y el chatbot -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div id="app"></div>
</body>
</html>
