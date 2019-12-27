<?php

namespace MaxKaemmerer\Console\Tests\Unit\Argument;

use MaxKaemmerer\Console\Argument\Argument;
use MaxKaemmerer\Console\Argument\GeneralArgument;
use PHPUnit\Framework\TestCase;

class ArgumentTest extends TestCase
{
    private const DESCRIPTION = 'description';

    private const NAME = 'name';

    private const DEFAULT = 5;

    private const EXPECTED_TYPE = 'int';

    private const PASSED_VALUE = '7';

    /** @var Argument */
    private $argument;

    protected function setUp(): void
    {
        $this->argument = Argument::create(self::NAME, self::DEFAULT, self::DESCRIPTION);
    }

    /**
     * @test
     **/
    public function shouldImplementGeneralArgument(): void
    {
        self::assertInstanceOf(GeneralArgument::class, $this->argument);
    }

    /**
     * @test
     **/
    public function shouldSetNameAndDescriptionCorrectly(): void{
        self::assertSame(self::DESCRIPTION, $this->argument->description());
        self::assertSame(self::NAME, $this->argument->name());
        self::assertSame(self::DEFAULT, $this->argument->defaultValue());
    }

    /**
    * @test
    **/
    public function shouldReturnDefaultValueIfArgumentWasNotPassed(): void{
        $result = $this->argument->parse([]);
        self::assertEquals(self::DEFAULT, $result);
        self::assertInternalType(self::EXPECTED_TYPE, $result);
    }

    /**
    * @test
    **/
    public function shouldReturnPassedValueIfArgumentWasPassed(): void{
        $result = $this->argument->parse([sprintf('--%s=%d', self::NAME, self::PASSED_VALUE)]);
        self::assertEquals(self::PASSED_VALUE, $result);
        self::assertInternalType(self::EXPECTED_TYPE, $result);
    }

    /**
    * @test
    **/
    public function shouldCastStringToIntIfDefaultValueIsOfTypeInt(): void{
        $argument =  Argument::create(self::NAME, 55);
        $result = $argument->parse([sprintf('--%s=%s', self::NAME, '5')]);
        self::assertEquals(5, $result);
        self::assertEquals(55, $argument->parse([]));
    }

    /**
    * @test
    **/
    public function shouldCastStringToArrayIfDefaultValueIsOfTypeArray(): void{
        $argument =  Argument::create(self::NAME, []);
        $result = $argument->parse([sprintf('--%s=%s', self::NAME, 'A,B,C')]);
        self::assertEquals(['A', 'B', 'C'], $result);
        self::assertEquals([], $argument->parse([]));
    }

    /**
    * @test
    **/
    public function shouldNotCastStringIfDefaultValueIsOfTypeNull(): void{
        $argument =  Argument::create(self::NAME, null);
        $result = $argument->parse([sprintf('--%s=%s', self::NAME, 'A,B,C')]);
        self::assertEquals('A,B,C', $result);
        self::assertEquals(null, $argument->parse([]));
    }
}
