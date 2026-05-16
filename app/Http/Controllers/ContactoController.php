<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactoController extends Controller
{
    /**
     * Mostrar el formulario de contacto
     */
    public function index()
    {
        return view('contacto');
    }

    /**
     * Procesar el formulario y guardar los datos
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|max:1000',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección válida.',
            'email.max' => 'El email no puede exceder 255 caracteres.',
            'mensaje.required' => 'El mensaje es obligatorio.',
            'mensaje.string' => 'El mensaje debe ser un texto válido.',
            'mensaje.max' => 'El mensaje no puede exceder 1000 caracteres.',
        ]);

        // Aquí puedes hacer algo con los datos validados:
        // - Guardarlos en la base de datos
        // - Enviar un email
        // - Registrar en un log, etc.

        // Por ahora, devolvemos un mensaje simple
        return back()->with('success', 'Formulario enviado correctamente');
    }
}