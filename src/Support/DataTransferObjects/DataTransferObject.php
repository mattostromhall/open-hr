<?php

namespace Support\DataTransferObjects;

use ReflectionClass;

abstract class DataTransferObject
{
    public static function from(array $data): static
    {
        $params = collect(
            (new ReflectionClass(get_called_class()))
            ->getConstructor()
            ->getParameters()
        )->pluck('name');

        $args = collect($data)
            ->filter(fn ($value, $key) => $params->contains($key))
            ->toArray();

        return new static(...$args);
    }
}
