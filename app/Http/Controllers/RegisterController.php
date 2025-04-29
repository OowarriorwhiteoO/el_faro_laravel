<?php

namespace App\Http\Controllers;

// Importaciones de clases necesarias.
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;     // Facade para hashing de contraseñas.
use Illuminate\Support\Facades\Auth;      // Facade para autenticación.
use Illuminate\Support\Facades\Validator; // Facade para validación de datos.
use Illuminate\Support\Facades\Log;       // Facade para registro de logs.
use Illuminate\Auth\Events\Registered;    // Evento disparado tras registro exitoso.
use Illuminate\Contracts\View\View;       // Interfaz para respuestas de vista.
use Illuminate\Http\RedirectResponse;   // Clase para respuestas de redirección.

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro de usuarios.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showRegistrationForm(): View
    {
        // Retorna la vista Blade ubicada en 'resources/views/auth/register.blade.php'.
        return view('auth.register');
    }

    /**
     * Procesa la solicitud POST para registrar un nuevo usuario.
     * Valida los datos, crea el usuario, inicia sesión y redirige.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        // Define las reglas de validación para los datos del formulario.
        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:255'], // Campo 'nombre' requerido.
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'], // Email requerido, formato válido y único en tabla 'usuarios'.
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Contraseña requerida, mínimo 8 caracteres y confirmada.
        ], [
            // Mensajes personalizados para errores de validación.
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        // Redirige de vuelta al formulario si la validación falla.
        if ($validator->fails()) {
            return redirect()->route('register.form')
                        ->withErrors($validator) // Pasa los errores a la sesión.
                        ->withInput(); // Mantiene los datos ingresados (excepto contraseña).
        }

        // Intenta crear el usuario si la validación es exitosa.
        try {
            // Obtiene los datos que pasaron la validación.
            $validatedData = $validator->validated();

            // Crea el nuevo usuario en la base de datos usando el modelo Usuario.
            $usuario = Usuario::create([
                'nombre' => $validatedData['nombre'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']), // Hashea la contraseña antes de guardarla.
            ]);

            // Dispara el evento 'Registered' (útil para acciones posteriores como enviar emails).
            // event(new Registered($usuario));

            // Inicia sesión automáticamente para el usuario recién registrado.
            Auth::login($usuario);

            // Redirige a la página de inicio con un mensaje de éxito en la sesión flash.
            return redirect()->route('home')->with('success', '¡Registro completado! Has iniciado sesión.');

        } catch (\Exception $e) {
            // Registra el error si la creación del usuario falla.
            Log::error("Error durante el registro: " . $e->getMessage());
            // Redirige de vuelta al formulario con un mensaje de error general.
            return redirect()->route('register.form')
                        ->with('error', 'Ocurrió un error durante el registro. Por favor, inténtalo de nuevo.')
                        ->withInput();
        }
    }
}
