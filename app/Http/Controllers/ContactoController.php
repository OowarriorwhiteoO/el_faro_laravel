<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\MensajeContacto; // <-- Importa el nuevo modelo
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class ContactoController extends Controller
{
    /**
     * Procesa el envío del formulario de contacto.
     * Valida los datos y los guarda en la base de datos.
     *
     * @param Request $request La petición HTTP entrante.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enviar(Request $request): RedirectResponse
    {
        // Define las reglas de validación.
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

        // Redirige si la validación falla.
        if ($validator->fails()) {
            return redirect(route('home') . '#contacto')
                   ->withErrors($validator)
                   ->withInput();
        }

        // Intenta guardar el mensaje en la base de datos.
        try {
            $validatedData = $validator->validated();

            // *** CÓDIGO MODIFICADO PARA GUARDAR EN BD ***
            // Utiliza el modelo MensajeContacto para crear un nuevo registro.
            MensajeContacto::create([
                'nombre' => $validatedData['name'], // Mapea 'name' del formulario a 'nombre' de la BD.
                'email' => $validatedData['email'],
                'mensaje' => $validatedData['message'], // Mapea 'message' del formulario a 'mensaje' de la BD.
            ]);
            // *** FIN CÓDIGO MODIFICADO ***

            // Redirige a la página de agradecimiento con un mensaje de éxito.
            return redirect()->route('contacto.gracias')
                         ->with('success', '¡Gracias por tu mensaje! Ha sido recibido correctamente.'); // Mensaje ligeramente modificado

        } catch (\Exception $e) {
            // Registra el error si falla el guardado en la base de datos.
            Log::error("Error al guardar mensaje de contacto: " . $e->getMessage());
            // Redirige de vuelta con un mensaje de error general.
            return redirect(route('home') . '#contacto')
                        ->with('error', 'Ocurrió un error al enviar tu mensaje. Por favor, inténtalo de nuevo.')
                        ->withInput();
        }
    }

    /**
     * Muestra la página de agradecimiento.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function mostrarGracias(): View|RedirectResponse
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
