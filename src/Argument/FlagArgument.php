<?php

declare(strict_types=1);

namespace MaxKaemmerer\Console\Argument;


final class FlagArgument implements InputArgument, ArgumentParser
{

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    private function __construct()
    {
    }

    public static function create(string $name, string $description): self
    {
        $instance = new self();
        $instance->name = $name;
        $instance->description = $description;
        return $instance;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    /**
     * @param array $arguments
     * @return mixed
     */
    public function parse(array $arguments)
    {
        return $this->name && preg_grep('/--' . $this->name . '/', $arguments);
    }
}