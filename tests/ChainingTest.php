<?php

declare(strict_types=1);
use Lucite\Container\Container;
use PHPUnit\Framework\TestCase;

final class ChainingTest extends TestCase
{
    public function testChainedAdd(): void
    {
        $container = new Container();
        $container
            ->add('testkey1', 'testvalue1')
             ->addConstructor('testkey2', function () {
                 return 'testvalue2';
             })
            ->addSingleton('testkey3', function () {
                return 'testvalue3';
            });
        # Should be true because we just added this key
        $this->assertTrue($container->has('testkey1'));
        $this->assertTrue($container->has('testkey2'));
        $this->assertTrue($container->has('testkey3'));
        $this->assertFalse($container->has('testkey4'));

        $this->assertSame($container->get('testkey1'), 'testvalue1');
        $this->assertSame($container->get('testkey2'), 'testvalue2');
        $this->assertSame($container->get('testkey3'), 'testvalue3');

    }
}
