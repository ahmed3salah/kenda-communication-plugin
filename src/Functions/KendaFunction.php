<?php

namespace Kenda\KendaCommunicationPlugin\Functions;

use Kenda\KendaCommunicationPlugin\Functions\Responses\Response;

abstract class KendaFunction
{
    protected array $parameters;

    protected mixed $user;

    public function __construct($parameters, $user = null)
    {
        $this->user = $user;
        $this->parameters = $parameters;
    }

    abstract public function execute() : Response;
}
