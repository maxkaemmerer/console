<?php

declare(strict_types=1);

namespace MaxKaemmerer\Console\Argument;


interface Defaults
{
    /**
     * @return mixed
     */
    public function defaultValue();
}