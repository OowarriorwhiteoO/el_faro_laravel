<?php

namespace App\Http\Controllers;

use App\Models\Usuario; // <-- Importa tu modelo Usuario
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Para hashear la contraseña
use Illuminate\Support\Facades\Auth; // Para iniciar sesión automáticamente (opcional)
use Illuminate\Support\Facades\Validator; // Para validar (alternativa a Request validation)
use Illuminate\Support\Facades\Log; // Para registrar errores
use Illuminate\Auth\Events\Registered; // Para eventos (opcional)

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showRegistrationForm()
    {
        // Retorna la vista que crearemos en el siguiente paso
        return view('auth.register'); // Asume que la vista estará en resources/views/auth/register.blade.php
    }

    /**
     * Maneja la petición de registro POST.
     * Valida los datos, crea un nuevo usuario, (opcionalmente) inicia sesión, y redirige.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // 1. Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:255'], // Cambiado 'name' a 'nombre' para coincidir con tu tabla/modelo
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'], // Valida unicidad en la tabla 'usuarios', columna 'email'
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' busca un campo llamado 'password_confirmation'
        ], [
            // Mensajes personalizados
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        // Si la validación falla, redirige de vuelta con errores y old input
        if ($validator->fails()) {
            return redirect()->route('register.form')
                        ->withErrors($validator)
                        ->withInput();
        }

        // 2. Crear el usuario en la base de datos
        try {
            $validatedData = $validator->validated(); // Obtiene los datos validados

            $usuario = Usuario::create([
                'nombre' => $validatedData['nombre'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']), // ¡Importante! Hashear la contraseña
            ]);

            // (Opcional) Disparar evento de usuario registrado (para enviar email de verificación, etc.)
            // event(new Registered($usuario));

            // (Opcional) Iniciar sesión automáticamente para el usuario recién registrado
            Auth::login($usuario);

            // 3. Redirigir al usuario (ej: a la página de inicio) con un mensaje de éxito
            return redirect()->route('home')->with('success', '¡Registro completado! Has iniciado sesión.');

        } catch (\Exception $e) {
            // Si algo falla durante la creación (ej: problema de BD)
            Log::error("Error durante el registro: " . $e->getMessage());
            // Redirige de vuelta con un mensaje de error general
            return redirect()->route('register.form')
                        ->with('error', 'Ocurrió un error durante el registro. Por favor, inténtalo de nuevo.')
                        ->withInput(); // Mantiene los datos (excepto contraseña)
        }
    }
}
