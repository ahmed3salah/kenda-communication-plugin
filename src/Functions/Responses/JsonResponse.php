<?php

namespace Kenda\KendaCommunicationPlugin\Functions\Responses;

class JsonResponse extends Response
{
    private array $data {
        get {
            return $this->data;
        }
    }
    private int $status {
        get {
            return $this->status;
        }
    }

    public function __construct(array $data, int $status = 200)
    {
        $this->data = $data;
        $this->status = $status;
    }

}
