<?php

namespace Support\DataTransferObjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use ReflectionClass;
use ReflectionParameter;
use UnitEnum;

abstract class DataTransferObject
{
    public static function from(array $data): static
    {
        ray($data);
        $reflectedDTO = new ReflectionClass(get_called_class());

        foreach ($reflectedDTO->getConstructor()->getParameters() as $param) {
            $data = static::resolveModel($param, $data);
            $data = static::resolveEnum($param, $data);
            $data = static::resolveCarbon($param, $data);
        }

        $params = collect(
            $reflectedDTO
                ->getConstructor()
                ->getParameters()
        )->pluck('name');

        $args = collect($data)->filter(
            fn ($value, $key) => $params->contains($key)
        );

        return new static(...$args);
    }

    protected static function resolveModel(ReflectionParameter $param, array $data): array
    {
        $paramType = $param->getType()->getName();

        if (
            array_key_exists($param->getName(), $data)
            && $data[$param->getName()] instanceof Model
        ) {
            return $data;
        }

        if (
            array_key_exists($param->getName(), $data)
            && ! $data[$param->getName()]
            && $param->allowsNull()
        ) {
            return $data;
        }

        if (
            class_exists($paramType)
            && is_a($paramType, Model::class, true)
        ) {
            $modelArg = $paramType::query()->find($data[$param->getName() . '_id']);
            $data[$param->getName()] = $modelArg;
        }

        return $data;
    }

    protected static function resolveEnum(ReflectionParameter $param, array $data): array
    {
        $paramType = $param->getType()->getName();
        $param->allowsNull();

        if (! array_key_exists($param->getName(), $data)) {
            return $data;
        }

        if (! $data[$param->getName()] && $param->allowsNull()) {
            return $data;
        }

        if ($data[$param->getName()] instanceof UnitEnum) {
            return $data;
        }

        if (class_exists($paramType) && enum_exists($paramType)) {
            $enum = $paramType::from($data[$param->getName()]);
            $data[$param->getName()] = $enum;
        }

        return $data;
    }

    protected static function resolveCarbon(ReflectionParameter $param, array $data): array
    {
        $paramType = $param->getType()->getName();

        if (! array_key_exists($param->getName(), $data)) {
            return $data;
        }

        if (! $data[$param->getName()] && $param->allowsNull()) {
            return $data;
        }

        if ($data[$param->getName()] instanceof Carbon) {
            return $data;
        }

        if (is_a($paramType, Carbon::class, true)) {
            $date = Carbon::parse($data[$param->getName()]);
            $data[$param->getName()] = $date;
        }

        return $data;
    }
}
