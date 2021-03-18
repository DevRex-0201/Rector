<?php

declare(strict_types=1);

use Rector\Symfony\ValueObjectFactory\ServiceMapFactory;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire()
        ->autoconfigure();

    $services->load('Rector\\', __DIR__ . '/../src')
        ->exclude([__DIR__ . '/../src/*/{Rector,ValueObject}']);
};
