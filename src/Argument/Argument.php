<?php

declare(strict_types=1);

namespace MaxKaemmerer\Console\Argument;


final class Argument implements GeneralArgument
{
    /** @var string */
    private $name;

    /** @var mixed */
    private $default;

    /** @var string */
    private $description;

    /**
     * @param string $name
     * @param $default
     * @param string $description
     * @return Argument
     */
    public static function create(string $name, $default, string $description = 'No Description.'): self
    {
        $instance = new self();
        $instance->name = $name;
        $instance->default = $default;
        $instance->description = $description;
        return $instance;
    }

    /**
     * @param array $arguments
     * @return mixed
     */
    public function parse(array $arguments)
    {
        foreach ($arguments as $argument) {
            if (preg_match('/--' . $this->name() . '=(.*)/', $argument, $matches)) {
                $value = $matches[1];
                settype($value, \gettype($this->defaultValue()));
                return $value;
            }
        }
        return $this->defaultValue();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function defaultValue()
    {
        return $this->default;
    }
}