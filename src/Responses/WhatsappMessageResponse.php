<?php

namespace Kenda\KendaCommunicationPlugin\Responses;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Kenda\KendaCommunicationPlugin\Facades\KendaCommunicationPlugin;

class WhatsappMessageResponse extends Response
{
    // message
    private string $message {
        get {
            return $this->message;
        }
    }

    // to phone
    private string $to {
        get {
            return $this->to;
        }
    }

    // from phone
    private ?string $from {
        get {
            return $this->from;
        }
    }

    public function __construct(string $message, string $to, ?string $from = null)
    {
        $this->message = $message;
        $this->to = $to;
        $this->from = $from;
    }

    public function execute(): \Illuminate\Http\JsonResponse
    {
        // send a WhatsApp message through the plugin facade
        try {
            $response = KendaCommunicationPlugin::sendWhatsappMessage($this->to, $this->message, $this->from);

            return response()->json([
                'type' => 'whatsapp_message',
                'message' => 'Whatsapp message sent successfully',
                'response' => $response,
            ]);

        } catch (Exception|GuzzleException $e) {
            return response()->json(['message' => 'An error occurred while sending the WhatsApp message'], 500);
        }

    }

}
