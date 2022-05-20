<?php

namespace App\Http\Support\ViewModels;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Reflection;
use ReflectionClass;
use ReflectionMethod;

abstract class ViewModel implements Arrayable
{
    public function all(): Collection
    {
        return collect((new ReflectionClass($this))->getMethods())
            ->reject(
                fn (ReflectionMethod $method) => in_array($method->getName(), ['__construct', '__invoke', 'all', 'toArray'])
            )
            ->filter(
                fn (ReflectionMethod $method) => in_array('public', Reflection::getModifierNames($method->getModifiers()))
            )
            ->mapWithKeys(fn (ReflectionMethod $method) => [
                Str::camel($method->getName()) => $this->{$method->getName()}(),
            ]);
    }

    public function toArray(): array
    {
        return $this->all()->toArray();
    }
}
