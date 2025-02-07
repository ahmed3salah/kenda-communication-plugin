<?php

use Illuminate\Support\Facades\Route;

Route::post('api/v1/kenda-communication',
    [\Kenda\KendaCommunicationPlugin\Controllers\KendaCommunicationProtocolController::class, 'process']);
