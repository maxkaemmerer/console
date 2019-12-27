<?php declare(strict_types=1);

use MaxKaemmerer\Console\Argument\Argument;

require_once __DIR__ . '/../vendor/autoload.php';

$myValue = Argument::create('anArgumentName', null, 'This is a description of the Argument')->parse($argv);
var_dump($myValue);