<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Necesario para Autenticación
use Illuminate\Http\RedirectResponse; // Para el tipo de retorno
use Illuminate\Support\Facades\Validator; // Para validación
use Illuminate\Validation\ValidationException; // Para manejar errores de validación específicos

class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        // Retorna la vista que crearemos en el siguiente paso
        return view('auth.login'); // Asume que la vista estará en resources/views/auth/login.blade.php
    }

    /**
     * Maneja la petición de inicio de sesión POST.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        // 1. Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Redirige si la validación básica falla
        if ($validator->fails()) {
            return redirect()->route('login')
                        ->withErrors($validator)
                        ->withInput($request->only('email')); // Solo devuelve el email, no la contraseña
        }

        // 2. Intentar autenticar al usuario
        $credentials = $validator->validated(); // Obtiene ['email' => ..., 'password' => ...]

        // Auth::attempt intenta verificar las credenciales contra la BD (usando el provider configurado)
        // El segundo argumento (true/false) es para la opción "Recordarme" (opcional)
        if (Auth::attempt($credentials, $request->boolean('remember'))) { // $request->boolean('remember') será true si el checkbox 'remember' está marcado
            // Si la autenticación es exitosa:
            $request->session()->regenerate(); // Regenera la ID de sesión (seguridad)

            // Redirige al usuario a la página a la que intentaba acceder antes de ser enviado al login,
            // o a la página de inicio ('/') si no había una página anterior.
            return redirect()->intended('/')->with('success', 'Has iniciado sesión correctamente.');
        }

        // 3. Si la autenticación falla:
        // Redirige de vuelta al formulario de login con un mensaje de error específico
        // y manteniendo el email que ingresó el usuario.
        throw ValidationException::withMessages([
            'email' => __('auth.failed'), // Mensaje genérico de Laravel para credenciales incorrectas
        ])->redirectTo(route('login')); // Asegura que redirige a la ruta 'login'

         /* Alternativa para redirigir manualmente si no quieres usar ValidationException:
         return back()->withErrors([
             'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
         ])->onlyInput('email'); // onlyInput solo devuelve el email
         */
    }


    /**
     * Cierra la sesión del usuario actual.
     * (Este método ya lo teníamos)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Has cerrado sesión correctamente.');
    }
}
