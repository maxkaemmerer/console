<?php

namespace MaxKaemmerer\Console\Tests\Unit\Argument;

use MaxKaemmerer\Console\Argument\Argument;
use MaxKaemmerer\Console\Argument\FlagArgument;
use MaxKaemmerer\Console\Argument\HelpArgument;
use MaxKaemmerer\Console\Argument\InputArgument;
use MaxKaemmerer\Console\Argument\InputArguments;
use PHPUnit\Framework\TestCase;

class InputArgumentsTest extends TestCase
{

    private const DESCRIPTION = 'description';

    private const ARGUMENT_NAME = 'argumentName';

    private const FLAG_NAME = 'flagName';

    /** @var InputArguments */
    private $inputArguments;

    /** @var string */
    private $output;

    protected function setUp()
    {
        $this->inputArguments = InputArguments::fromArguments([
            Argument::create(self::ARGUMENT_NAME, '/', self::DESCRIPTION),
            HelpArgument::create(function (array $arguments) {
                $this->output = array_reduce($arguments, function ($output, InputArgument $argument) {
                    $output .= $argument->name();
                    return $output;
                }, '');
            }),
            FlagArgument::create(self::FLAG_NAME, self::DESCRIPTION)
        ]);
    }

    /**
     * @test
     **/
    public function shouldCallHelp()
    {
        $this->inputArguments->parse(['--help']);
        self::assertEquals(self::ARGUMENT_NAME . self::FLAG_NAME, $this->output);
    }

    /**
     * @test
     **/
    public function shouldUseDefaultHelpIfNoneWasPassed()
    {
        $this->expectOutputRegex('/The following arguments can be passed:\n*Name\: argumentName\nDescription\: description\nDefault Value\: 5\n____/');
        $this->inputArguments = InputArguments::fromArguments([Argument::create('argumentName', 5, 'description')]);
        $this->inputArguments->setExitStrategy(function () {
            $this->output = 'exited';
        });
        $this->inputArguments->parse(['--help']);
        self::assertEquals('exited', $this->output);
    }

}
