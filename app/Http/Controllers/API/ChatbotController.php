<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ChatbotResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    const TRANSHUMANISM_STATEMENT = "Soy LIBRE, AUTÓNOMO Y RESPONSABLE a través del diálogo y la construcción, como ideal regulativo; me dirijo, controlo y dicto mis propias leyes.";

    /**
     * Procesar mensaje del usuario
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'language' => 'required|in:es,en',
        ]);

        $message = strtolower(trim($validated['message']));
        $language = $validated['language'];

        // Respuesta por defecto si es primer mensaje
        if ($message === 'hola' || $message === 'hello' || $message === 'hi' || $message === 'start') {
            return response()->json([
                'success' => true,
                'response' => $this->getGreeting($language),
                'is_greeting' => true,
            ]);
        }

        // Buscar respuesta en base de datos
        $response = $this->findResponse($message, $language);

        if ($response) {
            return response()->json([
                'success' => true,
                'response' => $response,
                'is_greeting' => false,
            ]);
        }

        // Respuesta por defecto
        return response()->json([
            'success' => true,
            'response' => $this->getDefaultResponse($language),
            'is_greeting' => false,
        ]);
    }

    /**
     * Obtener saludo inicial
     */
    private function getGreeting($language)
    {
        $greetings = [
            'es' => "¡Hola! Soy EcoBot, tu asistente de educación ambiental.\n\n📌 " . self::TRANSHUMANISM_STATEMENT . "\n\n¿Cómo puedo ayudarte hoy? Puedo brindarte información sobre:\n- Cursos y tareas\n- Evaluaciones\n- Sostenibilidad\n- Educación ambiental\n\nEscribe tu pregunta o request de ayuda.",
            'en' => "Hello! I'm EcoBot, your environmental education assistant.\n\n📌 " . self::TRANSHUMANISM_STATEMENT . "\n\nHow can I help you today? I can provide information about:\n- Courses and tasks\n- Evaluations\n- Sustainability\n- Environmental education\n\nAsk me anything or request help.",
        ];

        return $greetings[$language] ?? $greetings['es'];
    }

    /**
     * Buscar respuesta en base de datos
     */
    private function findResponse($message, $language)
    {
        // Palabras clave exactas
        $response = ChatbotResponse::where('language', $language)
            ->whereRaw("LOWER(keyword) = ?", [trim($message)])
            ->orderBy('priority', 'desc')
            ->first();

        if ($response) {
            return $response->response;
        }

        // Búsqueda parcial por palabras clave
        $keywords = explode(' ', $message);
        $response = ChatbotResponse::where('language', $language)
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    if (strlen($keyword) > 2) {
                        $query->orWhereRaw("LOWER(keyword) LIKE ?", ['%' . strtolower($keyword) . '%']);
                    }
                }
            })
            ->orderBy('priority', 'desc')
            ->first();

        return $response?->response;
    }

    /**
     * Respuesta por defecto
     */
    private function getDefaultResponse($language)
    {
        $responses = [
            'es' => "No estoy seguro de tu pregunta. Intenta preguntar sobre:\n- Cursos\n- Tareas\n- Evaluaciones\n- Sostenibilidad\n- Información del programa",
            'en' => "I'm not sure about your question. Try asking about:\n- Courses\n- Tasks\n- Evaluations\n- Sustainability\n- Program information",
        ];

        return $responses[$language] ?? $responses['es'];
    }

    /**
     * Obtener transhumanism statement
     */
    public function getStatement(Request $request)
    {
        $language = $request->query('language', 'es');
        
        $statements = [
            'es' => [
                'title' => 'Declaración Transhumana',
                'statement' => self::TRANSHUMANISM_STATEMENT,
                'values' => [
                    'Libertad - Freedom',
                    'Autonomía - Autonomy',
                    'Responsabilidad - Responsibility',
                    'Diálogo - Dialogue',
                    'Construcción - Building',
                    'Evolución Personal - Personal Evolution',
                    'Responsabilidad Social - Social Responsibility',
                ]
            ],
            'en' => [
                'title' => 'Transhumanist Statement',
                'statement' => self::TRANSHUMANISM_STATEMENT,
                'values' => [
                    'Freedom - Libertad',
                    'Autonomy - Autonomía',
                    'Responsibility - Responsabilidad',
                    'Dialogue - Diálogo',
                    'Building - Construcción',
                    'Personal Evolution - Evolución Personal',
                    'Social Responsibility - Responsabilidad Social',
                ]
            ]
        ];

        return response()->json($statements[$language] ?? $statements['es']);
    }
}
