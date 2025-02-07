<?php

return [

    /* -------------------------------------------------------------------------- */
    /*                                User Resolving */
    /* -------------------------------------------------------------------------- */
    'enable_user_resolving' => true,
    'enable_guest_user' => true,

    'user_model' => 'App\Models\User',
    'user_phone_number_column' => 'phone_number',

    /* -------------------------------------------------------------------------- */
    /*                                Function calls */
    /* -------------------------------------------------------------------------- */

    'functions' => [
        'example_function' => 'App\KendaCommunicationPlugin\Functions\ExampleFunction',
    ],

];
