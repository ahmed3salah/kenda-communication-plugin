<?php

namespace Kenda\KendaCommunicationPlugin\Commands;

use Illuminate\Console\Command;

class GenerateKendaFunctionCommand extends Command
{
    public $signature = 'kenda:generate-function';

    public $description = 'Generate a new function for communication with Kenda';

    public function handle(): int
    {
        $stub = file_get_contents(__DIR__ . '/../stubs/function.stub');

        $functionName = $this->ask('What is the name of the function?');

        // replace the {{NAMESPACE}} and the {{ACTION_NAME}} placeholders in the stub
        $stub = str_replace('{{ACTION_NAME}}', $functionName, $stub);
        $stub = str_replace('{{NAMESPACE}}', 'App\\Functions', $stub);

        // make sure the Functions directory exists
        if (!is_dir(app_path('Functions'))) {
            mkdir(app_path('Functions'));
        }

        // save the file in the app/Functions directory
        file_put_contents(app_path('Functions/' . $functionName . '.php'), $stub);

        $this->info('Function created successfully in app/Functions/' . $functionName . '.php');
        $this->info('You can now add your logic to the function');

        return self::SUCCESS;
    }
}
