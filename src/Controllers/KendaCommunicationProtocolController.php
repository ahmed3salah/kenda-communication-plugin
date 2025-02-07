<?php

namespace Kenda\KendaCommunicationPlugin\Controllers;

use Illuminate\Http\Request;

class KendaCommunicationProtocolController
{
    public function process(Request $request)
    {

        $request->validate([
            'senderPhoneNumber' => ['required', 'string'],
            'function' => ['required', 'string'],
            'parameters' => ['nullable', 'array'],
        ]);

        // Resolve the user
        $userModel = null;
        if (config('kenda-communication-plugin.enable_user_resolving')) {
            $userPhoneNumberColumn = config('kenda-communication-plugin.user_phone_number_column');
            // user model class (App\Models\User)
            $userModelClass = config('kenda-communication-plugin.user_model');
            $userModel = $userModelClass::where($userPhoneNumberColumn, $request->senderPhoneNumber)->first();
        }

        if (is_null($userModel) && ! config('kenda-communication-plugin.enable_guest_user')) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
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

        $result = $functionClass->newInstance($parameters, $userModel)->execute();

        dd($result);

        return response()->json([
            'message' => 'Function executed successfully',
            'result' => $result,
        ]);
    }
}
