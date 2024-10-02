<?php 
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Anura\AnuraDirect;

final class AnuraDirectTest extends TestCase
{
    private static AnuraDirect $direct;

    public function setUp(): void
    {
        self::$direct = new AnuraDirect('123456');
    }

    public function testEmptyInstanceHasError(): void
    {
        self::$direct->setInstance('');
        self::$direct->getResult('127.0.0.1');
        $this->assertSame('Instance not specified', self::$direct->getError());
    }

    public function testInvalidInstanceHasError(): void
    {
        self::$direct->setInstance('abcdefg');
        self::$direct->getResult('127.0.0.1');
        $this->assertSame('Instance not found', self::$direct->getError());
    }

    public function testCanAddAdditionalData(): void
    {
        self::$direct->addAdditionalData('1', 'test-value');
        $additionalData = self::$direct->getAdditionalData();

        $this->assertSame($additionalData['1'], 'test-value');
    }

    public function testCanUpdateAdditionalData(): void
    {
        self::$direct->addAdditionalData('1', 'test-value');
        self::$direct->addAdditionalData('1', 'updated-data');
        $additionalData = self::$direct->getAdditionalData();

        $this->assertSame($additionalData['1'], 'updated-data');
    }

    public function testCanRemoveAdditionalData(): void
    {
        self::$direct->addAdditionalData('1', 'test-value');
        self::$direct->removeAdditionalData('1');

        $additionalData = self::$direct->getAdditionalData();
        $this->assertSame(count($additionalData), 0);
    }
}