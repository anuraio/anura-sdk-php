<?php 
declare(strict_types = 1);

use Anura\AdditionalData;
use PHPUnit\Framework\TestCase;

final class AdditionalDataTest extends TestCase
{
    private static AdditionalData $additionalData;

    public function setUp(): void
    {
        self::$additionalData = new AdditionalData();
    }

    public function testAdditionalDataStartsEmpty(): void
    {
        $this->assertSame(self::$additionalData->size(), 0);
    }

    public function testCanAddAdditionalData(): void
    {
        self::$additionalData->addElement(1, 'test-value');
        echo self::$additionalData->__toString();

        $this->assertSame(self::$additionalData->size(), 1);
    }

    public function testCanUpdateAdditionalData(): void
    {
        self::$additionalData->addElement(1, 'test-value');
        self::$additionalData->addElement(1, 'updated-data');

        echo self::$additionalData->__toString();
        $this->assertSame(self::$additionalData->__toString(), '{"1":"updated-data"}');
    }

    public function testCanRemoveAdditionalData(): void
    {
        self::$additionalData->addElement(1, 'test-value');
        self::$additionalData->removeElement(1);
        
        $this->assertSame(self::$additionalData->size(), 0);
    }
}