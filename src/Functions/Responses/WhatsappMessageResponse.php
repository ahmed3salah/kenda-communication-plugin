<?php

namespace Kenda\KendaCommunicationPlugin\Functions\Responses;

class WhatsappMessageResponse extends Response
{
    private string $message {
        get {
            return $this->message;
        }
    }

    public function __construct(string $message)
    {
        $this->message = $message;
    }

}
