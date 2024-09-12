# Lucite\Container, a simple psr-11 DI container with a few extras bolted on and minimal magic

## Adding new keys
There are 3 methods for adding new keys:

- `function add(string $key, mixed $value)`
- `function addConstructor(string $key, callable $constructor)`
- `function addSingleton(string $key, callable $constructor)`
