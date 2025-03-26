<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Configuration
    |--------------------------------------------------------------------------
    |
    | This file is where you can configure Cross-Origin Resource Sharing (CORS)
    | settings for your application. By default, the package will allow any
    | domain to access your application. You can adjust these settings as needed.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    /*
     * Allowed HTTP methods. By default, all methods are allowed.
     */
    'allowed_methods' => ['*'], // Permite todos los métodos (GET, POST, PUT, DELETE, etc.)

    /*
     * Allowed origins. You can set this to an array of domains or use "*" for any domain.
     * You can also use regular expressions to match multiple origins.
     */
    'allowed_origins' => ['http://localhost:5173'], // Asegúrate de que el puerto sea el correcto de tu frontend

    /*
     * Allowed origins patterns. This is useful if you want to allow subdomains.
     */
    'allowed_origins_patterns' => [],

    /*
     * Allowed headers. You can set this to "*" to allow all headers.
     */
    'allowed_headers' => ['*'], // Permite todos los encabezados (Content-Type, Authorization, etc.)

    /*
     * Exposed headers. These headers will be exposed to the frontend.
     */
    'exposed_headers' => [],

    /*
     * Max age. The value, in seconds, of how long the results of a preflight request
     * can be cached by the browser. Default is 0 (no caching).
     */
    'max_age' => 0,

    /*
     * Indicates whether the response to the request can be exposed when the
     * credentials flag is true. Set this to true if your app uses cookies or
     * HTTP authentication.
     */
    'supports_credentials' => true,

];
