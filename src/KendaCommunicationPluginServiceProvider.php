<?php

namespace Kenda\KendaCommunicationPlugin;

use Kenda\KendaCommunicationPlugin\Commands\GenerateKendaFunctionCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class KendaCommunicationPluginServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('kenda-communication-plugin')
            ->hasRoute('api')
            ->hasConfigFile()
            ->hasCommand(GenerateKendaFunctionCommand::class)

        // ->hasViews()
        // ->hasMigration('create_kenda_communication_plugin_table')
        // ->hasCommand(KendaCommunicationPluginCommand::class)

        ;
    }
}
