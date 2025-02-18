<?php

namespace Kenda\KendaCommunicationPlugin\Responses;

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

    public function execute(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'type' => 'json_response',
            ...$this->data,
        ], $this->status);
    }
}
