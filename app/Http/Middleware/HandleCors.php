<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\HandleCors as Middleware;

class HandleCors extends Middleware
{
    /**
     * Get the CORS options for the application.
     *
     * @return array<string, mixed>
     */
    protected function corsOptions(): array
    {
        return [
            'paths' => ['api/*', 'sanctum/csrf-cookie'],

            'allowed_methods' => ['*'],

            'allowed_origins' => ['*'],

            'allowed_origins_patterns' => [],

            'allowed_headers' => ['*'],

            'exposed_headers' => [],

            'max_age' => 0,

            'supports_credentials' => true,
        ];
    }
}
