<?php

namespace Kenda\KendaCommunicationPlugin\Responses;

use Spatie\Crypto\Rsa\Exceptions\FileDoesNotExist;
use Spatie\Crypto\Rsa\PublicKey;

class AIResultResponse extends Response
{
    private string $response {
        get {
            return $this->response;
        }
    }

    private int $statusCode {
        get {
            return $this->statusCode;
        }
    }

    public function __construct(string $response, $statusCode = 200)
    {
        $this->response = $response;
        $this->statusCode = $statusCode;
    }

    public function execute(): \Illuminate\Http\JsonResponse
    {
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

        $response = $this->response;

        $encryptedResponse = $publicKey->encrypt($response);

        return response()->json([
            'type' => 'ai_result',
            'message' => 'AI result sent successfully',
            'api_key' => config('kenda-communication-plugin.api_key'),
            'response' => base64_encode($encryptedResponse),
        ], $this->statusCode);
    }
}
