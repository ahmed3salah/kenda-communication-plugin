<?php

namespace Kenda\KendaCommunicationPlugin\Functions;

abstract class KendaFunction
{
    protected array $parameters;

    protected $user;

    public function __construct($parameters, $user = null)
    {
        $this->user = $user;
        $this->parameters = $parameters;
    }

    abstract public function execute();
}
