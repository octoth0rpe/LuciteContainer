<?php

declare(strict_types=1);
use Lucite\Container\Container;
use Lucite\Container\DuplicateIdentifierException;
use PHPUnit\Framework\TestCase;

final class SimpleContainerTest extends TestCase
{
    public function testSimpleKeyCanBeAdded(): void
    {
        $container = new Container();
        $container->add('testkey', 'testvalue');
        # Should be true because we just added this key
        $this->assertTrue($container->has('testkey'));
        $this->assertSame($container->get('testkey'), 'testvalue');

        $this->assertFalse($container->has('UNKNOWN KEY'));
    }

    public function testRaisesErrorWhenAddingDupeKeys(): void
    {
        $container = new Container();
        $container->add('testkey', 'testvalue1');
        $this->expectException(DuplicateIdentifierException::class);
        $container->add('testkey', 'testvalue2');
    }
}
