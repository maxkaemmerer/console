<?php

declare(strict_types=1);

namespace MaxKaemmerer\Console\Argument;


final class InputArguments
{

    /** @var GeneralArgument[] */
    private $arguments = [];

    /** @var HelpArgument */
    private $help;

    /** @var \Closure */
    private $exitStrategy;

    private function __construct()
    {
    }

    /**
     * @param Argument[] $arguments
     * @return InputArguments
     */
    public static function fromArguments(array $arguments): self
    {
        $instance = new self();
        foreach ($arguments as $argument) {
            if ($argument instanceof HelpArgument) {
                $instance->help = $argument;
            } elseif ($argument instanceof InputArgument) {
                $instance->arguments[] = $argument;
            }
        }

        self::setDefaultHelp($instance);
        self::setDefaultExitStrategy($instance);

        return $instance;
    }

    /**
     * @param $instance
     */
    private static function setDefaultHelp($instance): void
    {
        if (!$instance->help) {
            $instance->help = HelpArgument::create(function (array $arguments) use ($instance) {
                if (\count($arguments)) {
                    echo 'The following arguments can be passed:' . PHP_EOL;
                }
                /** @var InputArgument $argument */
                foreach ($arguments as $argument) {
                    echo 'Name: ' . $argument->name() . PHP_EOL;
                    echo 'Description: ' . $argument->description() . PHP_EOL;
                    if ($argument instanceof Defaults) {
                        echo 'Default Value: ' . var_export($argument->defaultValue(), true) . PHP_EOL;
                    }
                    echo '_________________________________________________' . PHP_EOL;
                }
                ($instance->exitStrategy)();
            });
        }
    }

    /**
     * @param $instance
     */
    private static function setDefaultExitStrategy($instance): void
    {
        $instance->exitStrategy = function () {
            exit();
        };
    }

    public function parse(array $arguments): array
    {
        if ($this->help && preg_grep('/--help/', $arguments)) {
            $this->help->displayHelp($this->arguments);
        }

        $results = [];
        foreach ($this->arguments as $argument) {
            $results[] = $argument->parse($arguments);
        }

        return $results;
    }

    public function setExitStrategy(\Closure $exitStrategy): self
    {
        $this->exitStrategy = $exitStrategy;
        return $this;
    }
}