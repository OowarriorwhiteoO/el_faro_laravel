<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;                // Representa una petición HTTP entrante.
use Illuminate\Support\Facades\Log;         // Facade para registrar información y errores.
use Illuminate\Support\Facades\Validator;   // Facade para la validación de datos.
use Illuminate\Http\RedirectResponse;       // Clase para respuestas de redirección.
use Illuminate\Contracts\View\View;         // Interfaz para respuestas de vista.

class ContactoController extends Controller
{
    /**
     * Procesa el envío del formulario de contacto.
     * Valida los datos recibidos y redirige a una página de agradecimiento.
     *
     * @param Request $request La petición HTTP entrante con los datos del formulario.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enviar(Request $request): RedirectResponse
    {
        // Define las reglas de validación para los campos del formulario.
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|string|min:10',
        ], [
            // Mensajes de error personalizados.
            'name.required' => 'Por favor, ingresa tu nombre.',
            'email.required' => 'Por favor, ingresa tu correo electrónico.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'message.required' => 'Por favor, escribe tu mensaje.',
            'message.min' => 'El mensaje debe tener al menos 10 caracteres.',
        ]);

        // Comprueba si la validación ha fallado.
        if ($validator->fails()) {
            // Redirige de vuelta a la página anterior con los errores y los datos introducidos.
            return redirect(route('home') . '#contacto')
                   ->withErrors($validator)
                   ->withInput();
        }

        // Obtiene los datos que pasaron la validación.
        $validatedData = $validator->validated();
        // Registra la recepción de los datos del formulario (acción simulada).
        Log::info('Formulario de contacto recibido:', $validatedData);

        // Redirige a la ruta de agradecimiento con un mensaje flash de éxito.
        return redirect()->route('contacto.gracias')
                         ->with('success', '¡Gracias por tu mensaje! Nos pondremos en contacto contigo pronto.');
    }

    /**
     * Muestra la página de agradecimiento.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function mostrarGracias(): View|RedirectResponse // Añadido tipo de retorno
    {
        // Verifica si existe un mensaje de éxito en la sesión.
        if (session('success')) {
            // Retorna la vista 'contacto.gracias'.
            return view('contacto.gracias');
        }
        // Si no hay mensaje de éxito, redirige a la página de inicio.
        return redirect()->route('home');
    }
}
