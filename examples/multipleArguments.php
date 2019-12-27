<?php declare(strict_types=1);

use MaxKaemmerer\Console\Argument\Argument;
use MaxKaemmerer\Console\Argument\FlagArgument;
use MaxKaemmerer\Console\Argument\InputArguments;

require_once __DIR__ . '/../vendor/autoload.php';

$arguments = InputArguments::fromArguments([
    Argument::create('aggregateIds', [], 'The aggregateId to be deleted from snapshots'),
    Argument::create('aggregateVersion', 5, 'The aggregateVersion to be deleted from snapshots'),
    Argument::create('since', 'now', 'The point in time since when created aggregates are included.'),
    FlagArgument::create('rebuild', 'Pass if you want snapshots to be rebuilt afterwards.')
])->parse($argv);

var_dump($arguments);