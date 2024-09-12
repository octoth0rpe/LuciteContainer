<?php

declare(strict_types=1);

namespace Lucite\Container;

class DuplicateIdentifierException extends \Exception implements \Psr\Container\ContainerExceptionInterface
{
    public function __construct(string $id)
    {
        parent::__construct('Attempted to add a duplicate id: '.$id, 1);
    }
}
