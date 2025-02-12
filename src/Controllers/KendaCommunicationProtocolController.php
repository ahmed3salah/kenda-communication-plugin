<?php

namespace Kenda\KendaCommunicationPlugin\Controllers;

use Illuminate\Http\Request;
use ReflectionClass;
use ReflectionException;
use Spatie\Crypto\Rsa\PublicKey;

class KendaCommunicationProtocolController
{
    public function process(Request $request)
    {

        $request->validate([
            'senderPhoneNumber' => ['required', 'string'],
            'function' => ['required', 'string'],
            'parameters' => ['nullable', 'string'],
        ]);

        $publicKeyPath = config('kenda-communication-plugin.public_key_path');

        $publicKey = PublicKey::fromFile(storage_path($publicKeyPath));

        if (is_null($request->parameters)) {
            $decryptedParameters = null;
        } else {
            $decryptedParameters = $publicKey->decrypt(base64_decode($request->parameters));
        }

        $senderPhoneNumber = $publicKey->decrypt(base64_decode($request->senderPhoneNumber));
        $functionName = $publicKey->decrypt(base64_decode($request->function));
        $parameters = json_decode($decryptedParameters, true);


        // Resolve the user
        $userModel = null;
        if (config('kenda-communication-plugin.enable_user_resolving')) {
            $userPhoneNumberColumn = config('kenda-communication-plugin.user_phone_number_column');
            $userModelClass = config('kenda-communication-plugin.user_model');
            $userModel = $userModelClass::where($userPhoneNumberColumn, $senderPhoneNumber)->first();
        }

        if (is_null($userModel) && ! config('kenda-communication-plugin.enable_guest_user')) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

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

        try {
            $function = $functionClass->newInstance($parameters, $userModel);
        } catch (ReflectionException $e) {
            return response()->json([
                'message' => 'Function not found',
            ], 404);
        }

        try {
            $result = $function->execute();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while executing the function',
            ], 500);
        }

        dd($result);

        return response()->json([
            'message' => 'Function executed successfully',
            'result' => $result,
        ]);
    }
}
