<?php

declare(strict_types=1);

namespace MaxKaemmerer\Console\Argument;


final class InputArguments
{

    /** @var GeneralArgument[] */
    private $arguments = [];

    /** @var HelpArgument */
    private $help;

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
            } else {
                if ($argument instanceof InputArgument) {
                    $instance->arguments[] = $argument;
                }
            }
        }

        if (!$instance->help) {
            $instance->help = HelpArgument::create(function (array $arguments) {
                if(\count($arguments)){
                    echo 'The following arguments can be passed:' . PHP_EOL;
                }
                /** @var GeneralArgument $argument */
                foreach ($arguments as $argument) {
                    echo 'Name: ' . $argument->name() . PHP_EOL;
                    echo 'Description: ' . $argument->description() . PHP_EOL;
                    echo 'Default Value: ' . var_export($argument->defaultValue(), true) . PHP_EOL;
                    echo '_________________________________________________' . PHP_EOL;
                }
            });
        }
        return $instance;
    }

    public function parse(array $arguments): array
    {
        if ($this->help && preg_grep('/--help/', $arguments)) {
            $this->help->displayHelp($this->arguments);
            exit();
        }

        $results = [];
        foreach ($this->arguments as $argument) {
            $results[] = $argument->parse($arguments);
        }

        return $results;
    }
}