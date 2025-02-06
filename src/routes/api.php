<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('api/v1/kenda-communication', function (Request $request) {
    $request->validate([
        'senderPhoneNumber' => ['required', 'string'],
        'function' => ['required', 'string'],
        'parameters' => ['nullable', 'array'],
    ]);

    // Try to get the user of the request

    if(config('kenda-communication-plugin.enable_user_resolving')) {
        $userModel = config('kenda-communication-plugin.user_model');
        $userPhoneNumberColumn = config('kenda-communication-plugin.user_phone_number_column');

        $resolvedUser = $userModel::where($userPhoneNumberColumn, $request->senderPhoneNumber)->first();

        ray($resolvedUser);

        // if(!$resolvedUser) {
        //     return response()->json([
        //         'message' => 'User not found',
        //     ], 404);
        // }
    }






});