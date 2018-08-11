<?php

declare(strict_types=1);


namespace MaxKaemmerer\Console\Argument;

interface ArgumentParser
{
    /**
     * @param array $arguments
     * @return mixed
     */
    public function parse(array $arguments);
}