<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

use Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector;
use Rector\Removing\ValueObject\ArgumentRemover;
use Rector\Symfony\Rector\ClassMethod\MergeMethodAnnotationToRouteAnnotationRector;

return static function (RectorConfig $rectorConfig): void {
    $services = $rectorConfig->services();

    $services->set(ArgumentRemoverRector::class)
        ->configure([
            new ArgumentRemover(
                'Symfony\Component\Yaml\Yaml',
                'parse',
                2,
                ['Symfony\Component\Yaml\Yaml::PARSE_KEYS_AS_STRINGS']
            ),
        ]);

    $services->set(MergeMethodAnnotationToRouteAnnotationRector::class);
};
