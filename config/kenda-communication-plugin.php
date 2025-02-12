<?php

return [

    /* -------------------------------------------------------------------------- */
    /*                                Public Key */
    /* -------------------------------------------------------------------------- */

    'public_key_path' => env('KENDA_COMMUNICATION_PLUGIN_PUBLIC_KEY_PATH', 'public_key_server.kendaKey'),

    /* -------------------------------------------------------------------------- */
    /*                                User Resolving */
    /* -------------------------------------------------------------------------- */

    'enable_user_resolving' => env('KENDA_COMMUNICATION_PLUGIN_ENABLE_USER_RESOLVING', true),
    'enable_guest_user' => env('KENDA_COMMUNICATION_PLUGIN_ENABLE_GUEST_USER', true),

    'user_model' => env('KENDA_COMMUNICATION_PLUGIN_USER_MODEL', 'App\Models\User'),
    'user_phone_number_column' => env('KENDA_COMMUNICATION_PLUGIN_USER_PHONE_NUMBER_COLUMN', 'phone_number'),

    /* -------------------------------------------------------------------------- */
    /*                                Function calls */
    /* -------------------------------------------------------------------------- */

    'functions' => [
        'example_function' => 'App\KendaCommunicationPlugin\Functions\ExampleFunction',
    ],

];
