<?php

declare(strict_types=1);


namespace MaxKaemmerer\Console\Argument;


interface InputArgument
{
    public function name():string;

    public function description(): string;
}