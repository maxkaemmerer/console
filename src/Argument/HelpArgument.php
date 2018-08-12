<?php

declare(strict_types=1);

namespace MaxKaemmerer\Console\Argument;


final class HelpArgument implements InputArgument
{
    public const NAME = 'help';

    public const DESCRIPTION = 'displays help';

    /** @var \Closure */
    private $displayHelpClosure;

    private function __construct()
    {
    }

    /**
     * @param \Closure $displayHelp
     * @return HelpArgument
     */
    public static function create(\Closure $displayHelp): HelpArgument
    {
        $instance = new self();
        $instance->displayHelpClosure = $displayHelp;
        return $instance;
    }

    /**
     * @param array $arguments
     * @return mixed
     */
    public function displayHelp(array $arguments)
    {
        return ($this->displayHelpClosure)($arguments);
    }

    public function name(): string
    {
        return self::NAME;
    }

    public function description(): string
    {
        return self::DESCRIPTION;
    }
}