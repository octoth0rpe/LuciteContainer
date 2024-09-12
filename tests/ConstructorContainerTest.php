<?php

declare(strict_types=1);
use Lucite\Container\Container;
use Lucite\Container\DuplicateIdentifierException;
use PHPUnit\Framework\TestCase;

final class ConstructorContainerTest extends TestCase
{
    public function testConstructorKeyCanBeAdded(): void
    {
        $container = new Container();
        $container->addConstructor('testkey', function () {
            return 'testvalue';
        });
        # Should be true because we just added this key
        $this->assertTrue($container->has('testkey'));
        $this->assertSame($container->get('testkey'), 'testvalue');
    }

    public function testRaisesErrorWhenAddingDupeKeys(): void
    {
        $container = new Container();
        $container->addConstructor('testkey', function () {
            return 'testvalue';
        });
        $this->expectException(DuplicateIdentifierException::class);
        $container->addConstructor('testkey', function () {
            return 'testvalue';
        });
    }
}
