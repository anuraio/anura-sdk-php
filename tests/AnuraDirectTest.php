<?php 
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Anura\AnuraDirect;
use Anura\DirectRequestBuilder;
use Anura\Exceptions\AnuraClientException;

final class AnuraDirectTest extends TestCase
{
    private static AnuraDirect $direct;
    private static DirectRequestBuilder $builder;

    public function setUp(): void
    {
        self::$direct = new AnuraDirect('123456');
        self::$builder = new DirectRequestBuilder();
    }

    public function testEmptyInstanceHasError(): void
    {
        $this->expectException(AnuraClientException::class);

        self::$direct->setInstance('');

        $request = self::$builder->setIpAddress('127.0.0.1')->build();
        self::$direct->getResult($request);
    }

    public function testInvalidInstanceHasError(): void
    {
        $this->expectException(AnuraClientException::class);

        self::$direct->setInstance('abcdefg');

        $request = self::$builder->setIpAddress('127.0.0.1')->build();
        self::$direct->getResult($request);
    }
}