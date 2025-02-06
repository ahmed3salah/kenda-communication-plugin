<?php

namespace Kenda\KendaCommunicationPlugin\Commands;

use Illuminate\Console\Command;

class KendaCommunicationPluginCommand extends Command
{
    public $signature = 'kenda-communication-plugin';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
