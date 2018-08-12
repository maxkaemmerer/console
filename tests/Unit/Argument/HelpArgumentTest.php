<?php

namespace MaxKaemmerer\Console\Tests\Unit\Argument;

use MaxKaemmerer\Console\Argument\FlagArgument;
use MaxKaemmerer\Console\Argument\HelpArgument;
use MaxKaemmerer\Console\Argument\InputArgument;
use PHPUnit\Framework\TestCase;

class HelpArgumentTest extends TestCase
{
    /** @var HelpArgument */
    private $helpArgument;

    private $output;

    protected function setUp()
    {
        $this->helpArgument = HelpArgument::create(function ($arguments) {
            $this->output = array_reduce($arguments, function ($output, InputArgument $argument) {
                $output .= $argument->name();
                return $output;
            }, '');
        });
    }

    /**
     * @test
     **/
    public function shouldImplementInputArgument(): void
    {
        self::assertInstanceOf(InputArgument::class, $this->helpArgument);
    }

    /**
     * @test
     **/
    public function shouldExecuteDisplayHelpCorrectly()
    {
        $this->helpArgument->displayHelp([
            FlagArgument::create('flag1', ''),
            FlagArgument::create('flag2', ''),
        ]);
        self::assertEquals('flag1flag2', $this->output);
    }

    /**
     * @test
     **/
    public function shouldSetNameAndDescriptionCorrectly()
    {
        self::assertSame(HelpArgument::DESCRIPTION, $this->helpArgument->description());
        self::assertSame(HelpArgument::NAME, $this->helpArgument->name());
    }
}
