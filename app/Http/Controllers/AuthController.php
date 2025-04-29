<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Facade para Autenticación
use Illuminate\Http\RedirectResponse; // Clase para respuestas de redirección
use Illuminate\Support\Facades\Validator; // Facade para Validación
use Illuminate\Validation\ValidationException; // Excepción para errores de validación

class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        // Retorna la vista del formulario de login.
        return view('auth.login');
    }

    /**
     * Maneja la petición POST para iniciar sesión.
     * Valida las credenciales e intenta autenticar al usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        // Define las reglas de validación para email y contraseña.
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            // Mensajes de error personalizados.
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Redirige de vuelta si la validación inicial falla.
        if ($validator->fails()) {
            return redirect()->route('login')
                        ->withErrors($validator)
                        ->withInput($request->only('email')); // Devuelve solo el email.
        }

        // Obtiene las credenciales validadas.
        $credentials = $validator->validated();

        // Intenta autenticar al usuario con las credenciales proporcionadas.
        // Incluye la opción "Recordarme" si el checkbox fue marcado.
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenera el ID de sesión tras una autenticación exitosa.
            $request->session()->regenerate();

            // Redirige al usuario a su destino previo o a la home.
            return redirect()->intended('/')->with('success', 'Has iniciado sesión correctamente.');
        }

        // Si la autenticación falla, lanza una excepción de validación.
        // Esto redirige automáticamente al login mostrando el error asociado al campo email.
        throw ValidationException::withMessages([
            'email' => __('auth.failed'), // Usa el mensaje de error estándar de Laravel.
        ])->redirectTo(route('login'));
    }


    /**
     * Cierra la sesión del usuario autenticado actualmente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        // Cierra la sesión del usuario.
        Auth::logout();

        // Invalida la sesión actual.
        $request->session()->invalidate();

        // Regenera el token CSRF para la nueva sesión.
        $request->session()->regenerateToken();

        // Redirige a la página de inicio con un mensaje de éxito.
        return redirect('/')->with('success', 'Has cerrado sesión correctamente.');
    }
}
