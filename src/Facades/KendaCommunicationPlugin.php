<?php

namespace Kenda\KendaCommunicationPlugin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void sendWhatsappMessage(string $targetPhone, string $message, ?string $fromPhone = null): JsonResponse
 * @see \Kenda\KendaCommunicationPlugin\KendaCommunicationPlugin
 */
class KendaCommunicationPlugin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Kenda\KendaCommunicationPlugin\KendaCommunicationPlugin::class;
    }
}
