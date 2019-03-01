<?php
declare(strict_types=1);

namespace Config\Di;

class ServiceContainer
{
    private $registry = [];

    public function getService(string $name): object
    {
        if (!isset($this->registry[$name])) {
            throw new ServiceNotFoundException(
                sprintf('No service found with given name: %s', $name)
            );
        }

        return $this->registry[$name];
    }

    public function registerService(string $name, object $service): void
    {
        $this->registry[$name] = $service;
    }

    public function getServiceRegistry(): array
    {
        return $this->registry;
    }
}
