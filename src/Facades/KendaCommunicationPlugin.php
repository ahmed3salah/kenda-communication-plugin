<?php

namespace Kenda\KendaCommunicationPlugin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kenda\KendaCommunicationPlugin\KendaCommunicationPlugin
 */
class KendaCommunicationPlugin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Kenda\KendaCommunicationPlugin\KendaCommunicationPlugin::class;
    }
}
