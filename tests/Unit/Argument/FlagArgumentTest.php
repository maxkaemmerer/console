<?php

namespace MaxKaemmerer\Console\Tests\Unit\Argument;


use MaxKaemmerer\Console\Argument\FlagArgument;
use MaxKaemmerer\Console\Argument\InputArgument;
use PHPUnit\Framework\TestCase;

class FlagArgumentTest extends TestCase
{
    private const ARGUMENT_NAME = 'log';

    private const EXPECTED_RETURN_TYPE = 'bool';

    private const ARGUMENT = '--log';

    private const DESCRIPTION = 'logs process if true';

    /** @var FlagArgument */
    private $flagArgument;

    protected function setUp()
    {
        $this->flagArgument = FlagArgument::create(self::ARGUMENT_NAME, self::DESCRIPTION);
    }


    /**
     * @test
     **/
    public function shouldImplementInputArgument(): void
    {
        self::assertInstanceOf(InputArgument::class, $this->flagArgument);
    }

    /**
     * @test
     **/
    public function shouldReturnCorrectValueAndType(): void
    {
        $result = $this->flagArgument->parse([self::ARGUMENT]);
        self::assertTrue($result);
        self::assertInternalType(self::EXPECTED_RETURN_TYPE, $result);
    }

    /**
     * @test
     **/
    public function shouldReturnFalseIfNoFlagIsSet(): void
    {
        $result = $this->flagArgument->parse([]);
        self::assertFalse($result);
        self::assertInternalType(self::EXPECTED_RETURN_TYPE, $result);
    }

    /**
    * @test
    **/
    public function shouldSetNameAndDescriptionCorrectly(){
        self::assertSame(self::DESCRIPTION, $this->flagArgument->description());
        self::assertSame(self::ARGUMENT_NAME, $this->flagArgument->name());
    }
}
