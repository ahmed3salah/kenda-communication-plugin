<?php

namespace Kenda\KendaCommunicationPlugin\Controllers;

use Illuminate\Http\Request;
use Kenda\KendaCommunicationPlugin\Enums\RequestChannelsEnum;
use ReflectionClass;
use ReflectionException;
use Spatie\Crypto\Rsa\Exceptions\CouldNotDecryptData;
use Spatie\Crypto\Rsa\Exceptions\FileDoesNotExist;
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

        if (!file_exists(storage_path($publicKeyPath))) {
            return response()->json([
                'message' => 'Public key not found',
            ], 500);
        }

        try {
            $publicKey = PublicKey::fromFile(storage_path($publicKeyPath));
        } catch (FileDoesNotExist $e) {
            return response()->json([
                'message' => 'Public key not found',
            ], 500);
        }

        if (is_null($request->parameters)) {
            $decryptedParameters = null;
        } else {

            try {
                $decryptedParameters = $publicKey->decrypt(base64_decode($request->parameters));
            } catch (CouldNotDecryptData $e) {
                return response()->json([
                    'message' => 'Invalid parameters or could not decrypt parameters',
                ], 400);
            }
        }

        try {
            $senderPhoneNumber = $publicKey->decrypt(base64_decode($request->senderPhoneNumber));
        } catch (CouldNotDecryptData $e) {
            return response()->json([
                'message' => 'Invalid sender phone number or could not decrypt sender phone number',
            ], 400);
        }

        try {
            $functionName = $publicKey->decrypt(base64_decode($request->function));
        } catch (CouldNotDecryptData $e) {
            return response()->json([
                'message' => 'Invalid function or could not decrypt function',
            ], 400);
        }

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
            $requestChannel = RequestChannelsEnum::WHATSAPP;
            $parameters = json_decode($parameters, true);

            $function = $functionClass->newInstance($parameters, $requestChannel, $userModel, $senderPhoneNumber);
        } catch (ReflectionException $e) {
            return response()->json([
                'message' => 'Function not found',
            ], 404);
        }

        try {
            $response = $function->execute();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while executing the function',
            ], 500);
        }

        // Execute the response class
        $result = $response->execute();

        return response()->json([
            'message' => 'Function executed successfully',
            'result' => $result,
        ]);
    }
}
