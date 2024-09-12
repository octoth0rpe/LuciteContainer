<?php

declare(strict_types=1);
use Lucite\Container\Container;
use Lucite\Container\DuplicateIdentifierException;
use PHPUnit\Framework\TestCase;

final class SingletonContainerTest extends TestCase
{
    public function testSingletonKeyCanBeAdded(): void
    {
        $container = new Container();
        $container->addSingleton('testkey', function () {
            return microtime(true);
        });
        $this->assertTrue($container->has('testkey'));
        $value = $container->get('testkey');
        $this->assertIsFloat($value);
    }

    public function testSameValueIsReturnedUponMultipleCalls(): void
    {
        $container = new Container();
        $container->addSingleton('testkey', function () {
            return microtime(true);
        });
        $value1 = $container->get('testkey');
        usleep(1000);
        $value2 = $container->get('testkey');
        usleep(1000);
        $value3 = $container->get('testkey');
        $this->assertSame($value1, $value2);
        $this->assertSame($value2, $value3);
    }

    public function testRaisesErrorWhenAddingDupeKeys(): void
    {
        $container = new Container();
        $container->addSingleton('testkey', function () {
            return microtime(true);
        });
        $this->expectException(DuplicateIdentifierException::class);
        $container->addSingleton('testkey', function () {
            return microtime(true);
        });
    }
}
