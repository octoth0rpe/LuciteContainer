<?php

declare(strict_types=1);

namespace Lucite\Container;

class UnknownIdentifierException extends \Exception implements \Psr\Container\ContainerExceptionInterface
{
    public function __construct(string $id)
    {
        parent::__construct('Attempted to get an unknown id: '.$id, 1);
    }
}
