<?php

declare(strict_types=1);

namespace Lucite\Container;

class Container implements \Psr\Container\ContainerInterface
{
    public static int $SIMPLE = 0;
    public static int $CONSTRUCTABLE = 1;
    public static int $SINGLETON = 2;

    protected $values = [];

    public function has(string $key): bool
    {
        return isset($this->values[$key]);
    }

    public function get(string $key): mixed
    {
        if ($this->has($key) === false) {
            throw new UnknownIdentifierException($key);
        }
        switch ($this->values[$key][0]) {
            case self::$SIMPLE:
                return $this->values[$key][1];
            case self::$CONSTRUCTABLE:
                return $this->values[$key][1]();
            case self::$SINGLETON:
                if (count($this->values[$key]) < 3) {
                    $this->values[$key][] = $this->values[$key][1]();
                }
                return $this->values[$key][2];
        }
        return false;
    }

    /**
     * Add a new key to the container.
     *
     * @param string $key The unique identifier for the value in the container.
     * @param mixed $value The value associated with the key in the container.
     *
     * @throws DuplicateIdentifierException if a value already exists for the given key.
     * @return Container
     */
    public function add(string $key, mixed $value): Container
    {
        if ($this->has($key)) {
            throw new DuplicateIdentifierException($key);
        }
        $this->values[$key] = [
            self::$SIMPLE,
            $value,
        ];
        return $this;
    }

    /**
     * Add a new key to the container that uses a function to create the value.
     *
     * @param string $key The unique identifier for the value in the container.
     * @param mixed $constructor The function used to create a value for the given key.
     *
     * @throws DuplicateIdentifierException if a value already exists for the given key.
     * @return Container
     */
    public function addConstructor(string $key, callable $constructor): Container
    {
        if ($this->has($key)) {
            throw new DuplicateIdentifierException($key);
        }
        $this->values[$key] = [
            self::$CONSTRUCTABLE,
            $constructor,
        ];
        return $this;
    }

    /**
     * Add a new key to the container that uses a function to create a value only once. The
     * same created value will be returned by subsequent calls to get(). This is useful
     * for keys like database connections where you want to ensure that only a single
     * instance is created.
     *
     * @param string $key The unique identifier for the value in the container.
     * @param mixed $constructor The function used to create a value for the given key.
     *
     * @throws DuplicateIdentifierException if a value already exists for the given key.
     * @return Container
     */
    public function addSingleton(string $key, callable $constructor): Container
    {
        if ($this->has($key)) {
            throw new DuplicateIdentifierException($key);
        }
        $this->values[$key] = [
            self::$SINGLETON,
            $constructor,
        ];
        return $this;
    }
}
