<?php

namespace Kenda\KendaCommunicationPlugin\Functions;

use Kenda\KendaCommunicationPlugin\Enums\RequestChannelsEnum;
use Kenda\KendaCommunicationPlugin\Responses\Response;
use Kenda\KendaCommunicationPlugin\Responses\WhatsappMessageResponse;

abstract class KendaFunction
{
    protected array $parameters;
    protected RequestChannelsEnum $requestChannel;
    protected ?string $requestFromWho;
    protected mixed $user;

    public function __construct($parameters, RequestChannelsEnum $requestChannel, $user = null, $requestFromWho = null)
    {
        $this->parameters = $parameters;
        $this->user = $user;
        $this->requestFromWho = $requestFromWho;
        $this->requestChannel = $requestChannel;
    }

//    abstract public function execute(): Response;
    public function execute(): Response
    {
        $whatsappResponse = new WhatsappMessageResponse('Hello World', '1234567890');

        return $whatsappResponse;
    }
}
