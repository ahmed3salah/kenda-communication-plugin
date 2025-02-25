<?php

namespace Kenda\KendaCommunicationPlugin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Spatie\Crypto\Rsa\Exceptions\FileDoesNotExist;
use Spatie\Crypto\Rsa\PublicKey;

class KendaCommunicationPlugin
{
    private string $kendaSAASHost = 'https://whatsapp-saas.test';

    private string $sendWhatsappMessageEndpoint = 'api/v1/whatsapp/send';

    // send whatsapp message

    /**
     * @throws GuzzleException
     */
    public function sendWhatsappMessage(string $targetPhone, string $message, ?string $fromPhone = null): JsonResponse
    {
        $publicKeyPath = config('kenda-communication-plugin.public_key_path');

        if (! file_exists(storage_path($publicKeyPath))) {
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

        $encryptedMessage = $publicKey->encrypt($message);
        $encryptedPhone = $publicKey->encrypt($targetPhone);
        $fr = $fromPhone ?? config('kenda-communication-plugin.from_phone');
        $encryptedFromPhone = $publicKey->encrypt($fr);

        // send the message
        $client = new Client;
        $apiKey = config('kenda-communication-plugin.api_key');
        $jsonData = [
            'host' => config('app.url'),
            'api_key' => $apiKey,
            'phone' => base64_encode($encryptedPhone),
            'message' => base64_encode($encryptedMessage),
            'from_phone' => base64_encode($encryptedFromPhone),
        ];

        $response = $client->post("$this->kendaSAASHost/$this->sendWhatsappMessageEndpoint", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => $jsonData,
        ]);

        return response()->json([
            'message' => 'Request sent',
            'response' => json_decode($response->getBody()->getContents()),
        ]);
    }
}
