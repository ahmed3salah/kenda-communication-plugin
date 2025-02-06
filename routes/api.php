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

    if (config('kenda-communication-plugin.enable_user_resolving')) {
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

    $functionName = $request->get('function');
    $parameters = $request->get('parameters');

    if (! array_key_exists($functionName, config('kenda-communication-plugin.functions'))) {
        return response()->json([
            'message' => 'Function not found',
        ], 404);
    }

    $functionClass = config('kenda-communication-plugin.functions')[$functionName];

    try {
        $functionClass = new ReflectionClass($functionClass);
    } catch (ReflectionException $e) {
        return response()->json([
            'message' => 'Function not found',
        ], 404);
    }

    if (! $functionClass->isSubclassOf('Kenda\KendaCommunicationPlugin\Functions\KendaFunction')) {
        return response()->json([
            'message' => 'Function not found',
        ], 404);
    }

    $result = (new $functionClass($parameters, $userModel))->execute();

    return response()->json([
        'message' => 'Function executed successfully',
        'result' => $result,
    ]);
});
