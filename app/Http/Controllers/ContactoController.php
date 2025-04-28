<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Necesario para manejar la petición
use Illuminate\Support\Facades\Log; // Para registrar información (opcional)
use Illuminate\Support\Facades\Validator; // Para validar los datos del formulario

class ContactoController extends Controller
{
    /**
     * Procesa el envío del formulario de contacto.
     * Valida los datos recibidos y redirige a una página de agradecimiento.
     *
     * @param Request $request La petición HTTP entrante con los datos del formulario.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enviar(Request $request)
    {
        // 1. Validación de los datos del formulario
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100', // Campo 'name' es requerido, texto, máximo 100 caracteres
            'email' => 'required|email|max:100',   // Campo 'email' es requerido, formato email válido, máximo 100 caracteres
            'message' => 'required|string|min:10', // Campo 'message' es requerido, texto, mínimo 10 caracteres
        ], [
            // Mensajes de error personalizados (opcional)
            'name.required' => 'Por favor, ingresa tu nombre.',
            'email.required' => 'Por favor, ingresa tu correo electrónico.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'message.required' => 'Por favor, escribe tu mensaje.',
            'message.min' => 'El mensaje debe tener al menos 10 caracteres.',
        ]);

        // 2. Comprobar si la validación falla
        if ($validator->fails()) {
            // Si falla, redirige de vuelta al formulario anterior (la página de inicio en este caso)
            // con los errores de validación y los datos que el usuario ya había ingresado (old input).
            return redirect(route('home') . '#contacto') // Vuelve a la home, al ancla #contacto
                   ->withErrors($validator) // Envía los errores a la vista
                   ->withInput(); // Envía los datos anteriores para rellenar el formulario
        }

        // 3. Si la validación es exitosa:
        // Por ahora, solo registraremos los datos (simulando procesamiento).
        // En un futuro, aquí iría la lógica para enviar un email o guardar en BD.
        $validatedData = $validator->validated(); // Obtiene solo los datos validados
        Log::info('Formulario de contacto recibido:', $validatedData);

        // 4. Redirige a una página de agradecimiento con un mensaje de éxito.
        // El mensaje se almacena en la sesión flash (dura una sola petición).
        // NOTA: La ruta 'contacto.gracias' se definirá en el siguiente paso.
        return redirect()->route('contacto.gracias')
                         ->with('success', '¡Gracias por tu mensaje! Nos pondremos en contacto contigo pronto.');
    }

    /**
     * Muestra la página de agradecimiento.
     * (Necesita una ruta GET para esta página, que se definirá en el siguiente paso).
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function mostrarGracias()
    {
        // Solo muestra la vista si hay un mensaje de éxito en la sesión flash
        if (session('success')) {
            // Retorna la vista 'contacto.gracias' (resources/views/contacto/gracias.blade.php)
            // Esta vista se creará en un paso posterior.
            return view('contacto.gracias');
        }
        // Si alguien intenta acceder directamente sin enviar el form, redirige a la home
        return redirect()->route('home');
    }
}
