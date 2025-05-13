<?php

namespace App\Providers;

use App\Models\Articulo;
use App\Models\Usuario; // Asegúrate que este es tu modelo de Usuario
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// Ya no necesitamos use Illuminate\Support\Facades\Log; para los Gates

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate para determinar si un usuario puede actualizar un artículo
        Gate::define('update-articulo', function (Usuario $usuario, Articulo $articulo) {
            // El admin puede actualizar cualquier artículo
            // O el autor del artículo puede actualizarlo
            return $usuario->role === 'admin' || $usuario->idUsuario === $articulo->idUsuario;
        });

        // Gate para determinar si un usuario puede eliminar un artículo
        Gate::define('delete-articulo', function (Usuario $usuario, Articulo $articulo) {
            // El admin puede eliminar cualquier artículo
            // O el autor del artículo puede eliminarlo
            return $usuario->role === 'admin' || $usuario->idUsuario === $articulo->idUsuario;
        });

        // Opcional: Gate para ver si un usuario es admin (para otras partes de la app)
        Gate::define('view-admin-panel', function (Usuario $usuario) {
            return $usuario->role === 'admin';
        });
    }
}
