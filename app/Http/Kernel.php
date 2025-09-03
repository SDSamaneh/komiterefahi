<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\RoleMiddleware; // middleware جدید تو

class Kernel extends HttpKernel
{
      /**
       * Global HTTP middleware stack.
       */
      protected $middleware = [
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\TrustProxies::class,
      ];

      /**
       * Middleware groups.
       */
      protected $middlewareGroups = [
            'web' => [

                  \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                  \Illuminate\Session\Middleware\StartSession::class,
                  \Illuminate\View\Middleware\ShareErrorsFromSession::class,

                  \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],
            'api' => [
                  \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],
      ];

      /**
       * Route middleware.
       */
      protected $routeMiddleware = [
           
            'role' => RoleMiddleware::class,
      ];
}
